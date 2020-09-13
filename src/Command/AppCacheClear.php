<?php

namespace App\Command;

use Memcached;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppCacheClear extends Command
{
    public function configure(): void
    {
        $this
            ->setName('app:cache:clear')
            ->setDescription('clear memcached');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $cache = new Memcached();
        $cache->addServer('memcached', 11211);
        $cache->flush();

        return 1;
    }
}
