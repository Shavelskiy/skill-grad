<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramRequest;
use App\Entity\User;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProgramRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramRequest[]    findAll()
 * @method ProgramRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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
    public function getPaginatorResult(SearchQuery $searchQuery, ?User $user = null): PaginatorResult
    {
        $query = $this
            ->createQueryBuilder('p')
            ->addOrderBy('p.createdAt', 'desc');

        if ($user !== null) {
            $query
                ->andWhere('p.user = :user')
                ->setParameter('user', $user);
        }

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($searchQuery->getPageItemCount())
            ->setPage($searchQuery->getPage())
            ->getResult();
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
