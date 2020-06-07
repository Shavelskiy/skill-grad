<?php

namespace App\Messenger;

use App\Cache\RedisClient;
use App\Entity\ChatMessage;
use App\Entity\User;
use App\Entity\UserToken;
use App\Repository\UserRepository;
use App\Repository\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use RuntimeException;
use SplObjectStorage;

class Chat implements MessageComponentInterface
{
    protected SplObjectStorage $clients;
    protected EntityManagerInterface $em;
    protected UserRepository $userRepository;
    protected UserTokenRepository $userTokenRepository;

    protected const MSG_INIT = 'init';
    protected const MSG_FOCUS_IN = 'focusIn';
    protected const MSG_FOCUS_OUT = 'focusOut';
    protected const MSG_SEND_MESSAGE = 'sendMessage';

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        UserTokenRepository $userTokenRepository
    ) {
        $this->clients = new SplObjectStorage();
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->attach($conn);
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msgStr
     */
    public function onMessage(ConnectionInterface $from, $msgStr): void
    {
        $redis = RedisClient::getConnection();

        $msg = json_decode($msgStr, true, 512, JSON_THROW_ON_ERROR);

        switch ($msg['type']) {
            case self::MSG_INIT:
                try {
                    $chatToken = $this->userTokenRepository->findByTokenAndType($msg['token'], UserToken::TYPE_CHAT);
                    $user = $chatToken->getUser();

                    $idKey = $this->getUserIdKey($user->getId());
                    $pIdKey = $this->getUserPIdKey($from->resourceId);

                    $pIds = unserialize($redis->get($idKey));
                    if ($pIds === false) {
                        $pIds = [];
                    }

                    $pIds[] = $from->resourceId;
                    $redis->set($idKey, serialize($pIds));
                    $redis->set($pIdKey, $user->getId());

                    $status = 'success';
                } catch (Exception $e) {
                    $status = 'error';
                }

                $from->send(json_encode([
                    'type' => $msg['type'],
                    'status' => $status,
                ], JSON_THROW_ON_ERROR, 512));
                break;
            case self::MSG_FOCUS_IN:
            case self::MSG_FOCUS_OUT:
                $userId = $redis->get($this->getUserPIdKey($from->resourceId));

                $this->sendToClients($msg['userId'], [
                    'type' => $msg['type'],
                    'from' => $userId,
                ]);

                break;
            case self::MSG_SEND_MESSAGE:
                $userId = $redis->get($this->getUserPIdKey($from->resourceId));

                $chatMessage = (new ChatMessage())
                    ->setUser($this->getUserById($userId))
                    ->setRecipient($this->getUserById($msg['to']))
                    ->setMessage($msg['message']);

                $this->em->persist($chatMessage);
                $this->em->flush();

                $this->sendToClients($chatMessage->getRecipient()->getId(), [
                    'withId' => $chatMessage->getUser()->getId(),
                    'type' => $msg['type'],
                    'message' => $this->getMessageToSend($chatMessage),
                    'user' => $this->getUserToSend($chatMessage->getUser()),
                ]);

                $this->sendToClients($chatMessage->getUser()->getId(), [
                    'withId' => $chatMessage->getRecipient()->getId(),
                    'type' => $msg['type'],
                    'message' => $this->getMessageToSend($chatMessage),
                    'user' => $this->getUserToSend($chatMessage->getRecipient()),
                ]);

                break;
        }
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->deleteUserFromStorage($conn->resourceId);

        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $this->deleteUserFromStorage($conn->resourceId);

        $conn->close();
    }

    /**
     * @param $pId
     */
    protected function deleteUserFromStorage($pId): void
    {
        $redis = RedisClient::getConnection();

        $pIdKey = $this->getUserPIdKey($pId);
        $userId = $redis->get($pIdKey);
        $userIdKey = $this->getUserIdKey($userId);

        $pIds = unserialize($redis->get($userIdKey));

        foreach ($pIds as $key => $curPId) {
            if ($curPId === $pId) {
                unset($pIds[$key]);
            }
        }

        if (!empty($pIds)) {
            $redis->set($userIdKey, serialize($pIds));
        } else {
            $redis->del($userIdKey);
        }

        $redis->del($pIdKey);
    }

    protected function sendToClients($toUserId, $data): void
    {
        $redis = RedisClient::getConnection();

        $userPIds = unserialize($redis->get($this->getUserIdKey($toUserId)));

        if (($userPIds === false) || (empty($userPIds))) {
            return;
        }

        /** @var ConnectionInterface $client */
        foreach ($this->clients as $client) {
            if (in_array($client->resourceId, $userPIds, true)) {
                $client->send(json_encode($data));
            }
        }
    }

    protected function getUserIdKey($userId): string
    {
        return sprintf('user.chat.id.%s', $userId);
    }

    protected function getUserPIdKey($pid): string
    {
        return sprintf('user.chat.pid.%s', $pid);
    }

    protected function getMessageToSend(ChatMessage $chatMessage): array
    {
        return [
            'id' => $chatMessage->getId(),
            'message' => $chatMessage->getMessage(),
            'dateSend' => $chatMessage->getDateSend()->format('d.m.Y h:m:s'),
            'senderUsername' => $chatMessage->getUser()->getUsername(),
            'viewed' => $chatMessage->isViewed(),
        ];
    }

    protected function getUserToSend(User $user): array
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
        ];
    }

    public function getUserById($userId): User
    {
        $user = $this->userRepository->find($userId);

        if ($user instanceof User) {
            return $user;
        }

        throw new RuntimeException('user is not found');
    }
}
