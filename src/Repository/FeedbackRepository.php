<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Feedback;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getPaginatorResult(SearchQuery $searchQuery): PaginatorResult
    {
        $query = $this->createQueryBuilder('f');

        if ($searchQuery->getOrderField() !== null) {
            $query->addOrderBy('f.' . $searchQuery->getOrderField(), $searchQuery->getOrderType());
        }

        $query
            ->addOrderBy('f.createdAt', 'desc');

        foreach ($searchQuery->getSearch() as $field => $value) {
            switch ($field) {
                case 'id':
                    $query
                        ->andWhere('f.id = :id')
                        ->setParameter('id', (int)$value);
                    break;
                case 'author_name':
                    $query
                        ->andWhere('upper(f.authorName) like :authorName')
                        ->setParameter('authorName', '%' . mb_strtoupper($value) . '%');
                    break;
                case 'email':
                    $query
                        ->andWhere('email =  :authorName')
                        ->setParameter('email', $value);
                    break;
            }
        }

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($searchQuery->getPageItemCount())
            ->setPage($searchQuery->getPage())
            ->getResult();
    }
}
