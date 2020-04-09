<?php

namespace App\Command;

use App\Messenger\Chat;
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
    protected EntityManagerInterface $em;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);
        $this->logger = $logger;
        $this->em = $em;
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

        try {
            $server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new Chat($this->em)
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
