<?php

namespace App\Command;

use App\Messenger\Chat;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use App\Repository\UserTokenRepository;
use App\Service\ChatService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class ChatStartCommand extends Command
{
    protected LoggerInterface $logger;
    protected EntityManagerInterface $entityManager;
    protected UserRepository $userRepository;
    protected UserTokenRepository $userTokenRepository;
    protected ChatMessageRepository $chatMessageRepository;
    protected ChatService $chatService;

    public function __construct(
        LoggerInterface $logger,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserTokenRepository $userTokenRepository,
        ChatMessageRepository $chatMessageRepository,
        ChatService $chatService
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->chatMessageRepository = $chatMessageRepository;
        $this->chatService = $chatService;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:chat:start')
            ->setDescription('Start chat websocket server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->logger->info('Start chat server');
        $output->writeln('<info>Start</info>');

        try {
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new Chat($this->entityManager, $this->userRepository, $this->userTokenRepository, $this->chatMessageRepository, $this->chatService, $output)
                    )
                ),
                8080
            );

            $server->run();
        } catch (Throwable $e) {
            $this->logger->error(sprintf('Chat server error: %s', $e->getMessage()));
        }

        return 1;
    }
}
