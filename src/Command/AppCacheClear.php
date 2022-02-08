<?php

namespace App\Command;

use Memcached;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppCacheClear extends Command
{
    protected static $defaultName = 'app:cache:clear';

    public function configure(): void
    {
        $this->setDescription('clear memcached');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $cache = new Memcached();
        $cache->addServer('memcached', 11211);
        $cache->flush();

        return 1;
    }
}
