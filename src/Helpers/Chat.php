<?php

namespace App\Helpers;

use App\Entity\ChatMessage;
use App\Entity\User;
use App\Entity\UserToken;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use App\Repository\UserTokenRepository;
use App\Service\User\UserInfoInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Ratchet\ConnectionInterface;
use RuntimeException;
use SplObjectStorage;
use Symfony\Component\Console\Output\OutputInterface;

class Chat {
    protected const MSG_INIT = 'init';
    protected const MSG_FOCUS_IN = 'focusIn';
    protected const MSG_FOCUS_OUT = 'focusOut';
    protected const MSG_SEND_MESSAGE = 'sendMessage';
    protected const MSG_VIEWED = 'viewed';

    protected SplObjectStorage $clients;
    protected EntityManagerInterface $entityManager;
    protected UserRepository $userRepository;
    protected UserTokenRepository $userTokenRepository;
    protected ChatMessageRepository $chatMessageRepository;
    protected UserInfoInterface $userService;
    protected OutputInterface $output;

    protected array $usersToResourcesMap = [];
    protected array $resourcesToUsersMap = [];

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserTokenRepository $userTokenRepository,
        ChatMessageRepository $chatMessageRepository,
        UserInfoInterface $userService,
        OutputInterface $output
    ) {
        $this->clients = new SplObjectStorage();
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->chatMessageRepository = $chatMessageRepository;
        $this->userService = $userService;
        $this->output = $output;
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        $this->output->write('<comment>Open connection</comment>', true);
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg): void
    {
        $this->output->write(sprintf('<question>Message from: %s, %s</question>', $from->resourceId, $msg), true);

        $message = json_decode($msg, true);

        switch ($message['type']) {
            case self::MSG_INIT:
                $this->onInit($message, $from);
                break;
            case self::MSG_FOCUS_IN:
            case self::MSG_FOCUS_OUT:
                $this->onFocusChange($message, $from);
                break;
            case self::MSG_SEND_MESSAGE:
                $this->onChatMessage($message, $from);
                break;
            case self::MSG_VIEWED:
                $this->onViewed($message, $from);
                break;
        }
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->output->write(sprintf('<error>Close: %s</error>', $conn->resourceId), true);

        $userId = $this->resourcesToUsersMap[$conn->resourceId];
        unset($this->resourcesToUsersMap[$conn->resourceId]);
        $this->usersToResourcesMap[$userId] = array_filter($this->usersToResourcesMap[$userId], static fn (int $resourceId) => $resourceId !== $conn->resourceId);

        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $this->output->write(sprintf('<error>Error: %s</error>', $e->getMessage()), true);

        $userId = $this->resourcesToUsersMap[$conn->resourceId];
        unset($this->resourcesToUsersMap[$conn->resourceId]);
        $this->usersToResourcesMap[$userId] = array_filter($this->usersToResourcesMap[$userId], static fn (int $resourceId) => $resourceId !== $conn->resourceId);

        $conn->close();
    }

    public function onInit(array $msg, ConnectionInterface $from): void
    {
        try {
            $chatToken = $this->userTokenRepository
                ->findByTokenAndType($msg['token'], UserToken::TYPE_CHAT);
            $user = $chatToken->getUser();

            if (!isset($this->usersToResourcesMap[$user->getId()])) {
                $this->usersToResourcesMap[$user->getId()] = [];
            }

            $this->usersToResourcesMap[$user->getId()][] = $from->resourceId;
            $this->resourcesToUsersMap[$from->resourceId] = $user->getId();

            $status = 'success';
        } catch (Exception $e) {
            $status = 'error';
        }

        $from->send(json_encode([
            'type' => $msg['type'],
            'status' => $status,
        ]));
    }

    public function onFocusChange(array $msg, ConnectionInterface $from): void
    {
        $this->sendToClients($msg['recipient'], [
            'type' => $msg['type'],
            'from' => $this->resourcesToUsersMap[$from->resourceId],
        ]);
    }

    public function onChatMessage(array $msg, ConnectionInterface $from): void
    {
        $chatMessage = (new ChatMessage())
            ->setUser($this->getUserById($this->resourcesToUsersMap[$from->resourceId]))
            ->setRecipient($this->getUserById($msg['recipient']))
            ->setMessage($msg['message']);

        $this->entityManager->persist($chatMessage);
        $this->entityManager->flush();

        $this->sendToClients($chatMessage->getRecipient()->getId(), [
            'type' => $msg['type'],
            'author' => [
                'name' => $this->userService->getUsername($chatMessage->getUser()),
                'image' => $this->userService->getUserPhoto($chatMessage->getUser()),
            ],
            'text' => $chatMessage->getMessage(),
        ]);

        $this->sendToClients($chatMessage->getUser()->getId(), [
            'type' => $msg['type'],
        ]);
    }

    public function onViewed(array $msg, ConnectionInterface $from): void
    {
        $user = $this->getUserById($this->resourcesToUsersMap[$from->resourceId]);
        $recipient = $this->getUserById($msg['recipient']);

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
    }

    protected function sendToClients($toUserId, $data): void
    {
        if (!isset($this->usersToResourcesMap[$toUserId])) {
            return;
        }

        /** @var ConnectionInterface $client */
        foreach ($this->clients as $client) {
            if (in_array($client->resourceId, $this->usersToResourcesMap[$toUserId], true)) {
                $client->send(json_encode($data));
            }
        }
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
