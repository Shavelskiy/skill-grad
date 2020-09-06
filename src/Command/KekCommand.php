<?php

namespace App\Command;

use App\Entity\Program\Program;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class KekCommand extends Command
{
    protected EntityManagerInterface $entityManager;
    protected ProgramRepository $programRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgramRepository $programRepository
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->programRepository = $programRepository;
    }

    public function configure(): void
    {
        $this->setName('app:kek');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var Program $program */
        $program = $this->programRepository->find(1);

        $program->setIncludes([
            'values' => [],
            'other_value' => '',
        ]);

        $this->entityManager->persist($program);
        $this->entityManager->flush();

        return 1;
    }
}