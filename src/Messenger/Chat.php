<?php

namespace App\Messenger;

use App\Cache\RedisClient;
use App\Entity\ChatMessage;
use App\Entity\User;
use App\Entity\UserToken;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use App\Repository\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use RuntimeException;
use SplObjectStorage;
use Symfony\Component\Console\Output\OutputInterface;

class Chat implements MessageComponentInterface
{
    protected SplObjectStorage $clients;
    protected EntityManagerInterface $entityManager;
    protected UserRepository $userRepository;
    protected UserTokenRepository $userTokenRepository;
    protected ChatMessageRepository $chatMessageRepository;
    protected OutputInterface $output;

    protected const MSG_INIT = 'init';
    protected const MSG_FOCUS_IN = 'focusIn';
    protected const MSG_FOCUS_OUT = 'focusOut';
    protected const MSG_SEND_MESSAGE = 'sendMessage';
    protected const MSG_VIEWED = 'viewed';

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserTokenRepository $userTokenRepository,
        ChatMessageRepository $chatMessageRepository,
        OutputInterface $output
    ) {
        $this->clients = new SplObjectStorage();
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->chatMessageRepository = $chatMessageRepository;
        $this->output = $output;
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        $this->output->write('<comment>Open connection</comment>', true);
        $this->clients->attach($conn);
    }

    /**
     * @param string $msgStr
     */
    public function onMessage(ConnectionInterface $from, $msgStr): void
    {
        $this->output->write(sprintf('<question>Message from: %s, %s</question>', $from->resourceId, $msgStr), true);

        $redis = RedisClient::getConnection();

        $msg = json_decode($msgStr, true);

        switch ($msg['type']) {
            case self::MSG_INIT:
                try {
                    $chatToken = $this->userTokenRepository
                        ->findByTokenAndType($msg['token'], UserToken::TYPE_CHAT);
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
                ]));
                break;
            case self::MSG_FOCUS_IN:
            case self::MSG_FOCUS_OUT:
                $userId = $redis->get($this->getUserPIdKey($from->resourceId));

                $this->sendToClients($msg['recipient'], [
                    'type' => $msg['type'],
                    'from' => $userId,
                ]);

                break;
            case self::MSG_SEND_MESSAGE:
                $userId = $redis->get($this->getUserPIdKey($from->resourceId));

                $chatMessage = (new ChatMessage())
                    ->setUser($this->getUserById($userId))
                    ->setRecipient($this->getUserById($msg['recipient']))
                    ->setMessage($msg['message']);

                $this->entityManager->persist($chatMessage);
                $this->entityManager->flush();

                $this->sendToClients($chatMessage->getRecipient()->getId(), [
                    'withId' => $chatMessage->getUser()->getId(),
                    'type' => $msg['type'],
                    'message' => $this->getMessageToSend($chatMessage),
                    'author' => [
                        'name' => $chatMessage->getUser()->getEmail(),
                    ],
                    'text' => $chatMessage->getMessage(),
                    'user' => $this->getUserToSend($chatMessage->getUser()),
                ]);

                $this->sendToClients($chatMessage->getUser()->getId(), [
                    'withId' => $chatMessage->getRecipient()->getId(),
                    'type' => $msg['type'],
                    'message' => $this->getMessageToSend($chatMessage),
                    'user' => $this->getUserToSend($chatMessage->getRecipient()),
                ]);

                break;
            case self::MSG_VIEWED:
                $userId = $redis->get($this->getUserPIdKey($from->resourceId));

                $user = $this->getUserById($userId);

                $recipient = $this->userRepository->find($msg['recipient']);

                foreach ($this->chatMessageRepository->findNewMessages($recipient, $user) as $chatMessage) {
                    $chatMessage->setViewed(true);
                    $this->entityManager->persist($chatMessage);
                }

                $this->entityManager->flush();

                $this->sendToClients($recipient->getId(), [
                    'for_self' => false,
                    'type' => $msg['type'],
                    'recipient' => $user->getId(),
                ]);

                $this->sendToClients($user->getId(), [
                    'for_self' => true,
                    'type' => $msg['type'],
                    'recipient' => $user->getId(),
                ]);

                break;
        }
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->output->write(sprintf('<error>Close: %s</error>', $conn->resourceId), true);
        $this->deleteUserFromStorage($conn->resourceId);

        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $this->output->write(sprintf('<error>Error: %s</error>', $e->getMessage()), true);
        $this->deleteUserFromStorage($conn->resourceId);

        $conn->close();
    }

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
