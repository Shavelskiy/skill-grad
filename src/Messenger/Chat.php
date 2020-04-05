<?php

namespace App\Messenger;

use App\Adapter\RedisClient;
use App\Entity\ChatMessage;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use RuntimeException;
use SplObjectStorage;

class Chat implements MessageComponentInterface
{
    protected $clients;

    protected $logger;
    protected $em;

    protected $userRepository;

    protected const MSG_INIT = 'init';
    protected const MSG_FOCUS_IN = 'focusIn';
    protected const MSG_FOCUS_OUT = 'focusOut';
    protected const MSG_SEND_MESSAGE = 'sendMessage';

    public function __construct(LoggerInterface $logger, EntityManagerInterface $em)
    {
        $this->clients = new SplObjectStorage();
        $this->logger = $logger;
        $this->em = $em;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->attach($conn);
        $this->logger->alert(sprintf('new socket connection %s', $conn->resourceId));
    }

    /**
     * @param ConnectionInterface $from
     * @param string $msgStr
     */
    public function onMessage(ConnectionInterface $from, $msgStr): void
    {
        $redis = RedisClient::getConnection();

        $msg = json_decode($msgStr, true);

        switch ($msg['type']) {
            case self::MSG_INIT:
                try {
                    $userRepository = $this->em->getRepository(User::class);
                    $user = $userRepository->findByChatToken($msg['token']);

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
                ]));
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

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn): void
    {
        $this->deleteUserFromStorage($conn->resourceId);

        $this->clients->detach($conn);
        $this->logger->alert(sprintf('destroy socket connection %s', $conn->resourceId));
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     */
    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $this->deleteUserFromStorage($conn->resourceId);

        $this->logger->alert(sprintf('socket connection %s, error %s', $conn->resourceId, $e->getMessage()));
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
        $user = $this->getUserRepository()->find($userId);

        if ($user instanceof User) {
            return $user;
        }

        throw new RuntimeException('user is not found');
    }

    protected function getUserRepository(): UserRepository
    {
        if ($this->userRepository === null) {
            $this->userRepository = $this->em->getRepository(User::class);
        }

        return $this->userRepository;
    }
}
