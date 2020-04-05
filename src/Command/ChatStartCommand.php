<?php

namespace App\Command;

use App\Messenger\Chat;
use Doctrine\ORM\EntityManagerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChatStartCommand extends Command
{
    protected static $defaultName = 'app:chat:start';

    protected $em;

    public function __construct(EntityManagerInterface $em, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Start chat websocket server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat($$this->em)
                )
            ),
            8080
        );

        $server->run();

        return 1;
    }
}
