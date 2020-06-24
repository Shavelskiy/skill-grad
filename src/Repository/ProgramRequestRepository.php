<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramRequest;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class ProgramRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramRequest::class);
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getProgramRequestsCount(Program $program): int
    {
        return $this->createQueryBuilder('pr')
            ->select('count(pr.id)')
            ->andWhere('pr.program = :program')
            ->setParameter('program', $program)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getNewProgramRequestsCount(Program $program): int
    {
        return $this->createQueryBuilder('pr')
            ->select('count(pr.id)')
            ->andWhere('pr.program = :program')
            ->andWhere('pr.status = :status')
            ->setParameters([
                'program' => $program,
                'status' => ProgramRequest::STATUS_NEW,
            ])
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Paginator
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getPaginatorProgramItems(Program $program, int $page = 1, int $pageItems = 10): PaginatorResult
    {
        $query = $this->createQueryBuilder('pr')
            ->andWhere('pr.program = :program')
            ->setParameter('program', $program);

        return (new Paginator())
            ->setQuery($query)
            ->setPage($page)
            ->getResult();
    }
}
