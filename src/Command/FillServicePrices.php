<?php

namespace App\Command;

use App\Entity\Service\ServicePrice;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillServicePrices extends Command
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    public function configure(): void
    {
        $this
            ->setName('app:fill-service-price');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $prices = [
            ServicePrice::PROGRAM_HIGHLIGHT => 990,
            ServicePrice::PROGRAM_RAISE => 490,
            ServicePrice::PROGRAM_HIGHLIGHT_RISE => 1290,
            ServicePrice::PRO_ACCOUNT => 1990,
        ];

        foreach ($prices as $type => $price) {
            $servicePrice = (new ServicePrice())
                ->setType($type)
                ->setPrice($price);

            $this->entityManager->persist($servicePrice);
        }

        $this->entityManager->flush();

        return 1;
    }
}