<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramQuestion;
use App\Entity\User;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProgramQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramQuestion[]    findAll()
 * @method ProgramQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
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
