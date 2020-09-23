<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramReview;
use App\Entity\User;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProgramReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgramReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgramReview[]    findAll()
 * @method ProgramReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramReviewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProgramReview::class);
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getPaginatorResult(SearchQuery $searchQuery, Program $program): PaginatorResult
    {
        $query = $this
            ->createQueryBuilder('p')
            ->addOrderBy('p.createdAt', 'desc');
//            ->andWhere('p.program = :program')
//            ->setParameter('program', $program);

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($searchQuery->getPageItemCount())
            ->setPage($searchQuery->getPage())
            ->getResult();
    }

    public function findUserProgramsReviews(User $user, array $programIds): array
    {
        return $this
            ->createQueryBuilder('p')
            ->join('p.program', 'pr')
            ->andWhere('p.user = :user')
            ->andWhere('pr.id in (:ids)')
            ->setParameters([
                'user' => $user,
                'ids' => $programIds,
            ])
            ->getQuery()
            ->getResult();
    }
}
