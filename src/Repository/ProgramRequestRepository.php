<?php

namespace App\Repository;

use App\Dto\Paginator;
use App\Entity\Program;
use App\Entity\ProgramRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProgramRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramRequest::class);
    }

    /**
     * @param Program $program
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
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
     * @param Program $program
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
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
     * @param Program $program
     * @param int     $page
     * @param int     $pageItems
     *
     * @return Paginator
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPaginatorProgramItems(Program $program, int $page = 1, int $pageItems = 10): Paginator
    {
        $query = $this->createQueryBuilder('pr')
            ->andWhere('pr.program = :program')
            ->setParameter('program', $program);

        $programs = (clone $query)
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $totalCount = (clone $query)
            ->select('count(pr.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return (new Paginator())
            ->setItems($programs)
            ->setCurrentPage($page)
            ->setTotalPageCount(ceil($totalCount / $pageItems));
    }
}
