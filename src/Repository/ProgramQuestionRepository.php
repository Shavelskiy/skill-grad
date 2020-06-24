<?php

namespace App\Repository;

use App\Entity\Program\Program;
use App\Entity\Program\ProgramQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class ProgramQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramQuestion::class);
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
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
     * @throws NoResultException
     * @throws NonUniqueResultException
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
