<?php

namespace App\Repository;

use App\Entity\Program;
use App\Entity\ProgramQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProgramQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramQuestion::class);
    }

    public function getProgramQuestionCount(Program $program): int
    {
        return $this->createQueryBuilder('pq')
            ->select('count(pq.id)')
            ->andWhere('pq.program = :program')
            ->setParameter('program', $program)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param Program $program
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getNewProgramQuestionCount(Program $program): int
    {
        return $this->createQueryBuilder('pq')
            ->select('count(pq.id)')
            ->andWhere('pq.program = :program')
            ->andWhere('pq.answer is null')
            ->setParameter('program', $program)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
