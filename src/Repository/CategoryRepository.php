<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Category;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return Category[]
     */
    public function findRootCategories(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.parentCategory is null')
            ->orderBy('c.sort', 'asc')
            ->getQuery()
            ->getResult();
    }

    public function findChildCategories(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.parentCategory is not null')
            ->orderBy('c.sort', 'asc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getPaginatorResult(SearchQuery $searchQuery): PaginatorResult
    {
        $query = $this->createQueryBuilder('c');

        if ($searchQuery->getOrderField() !== null) {
            $query->addOrderBy('c.' . $searchQuery->getOrderField(), $searchQuery->getOrderType());
        }

        $query
            ->addOrderBy('c.id', 'asc')
            ->addOrderBy('c.sort', 'asc');

        foreach ($searchQuery->getSearch() as $field => $value) {
            switch ($field) {
                case 'id':
                    $query
                        ->andWhere('c.id = :id')
                        ->setParameter('id', (int)$value);
                    break;
                case 'name':
                    $query
                        ->andWhere('upper(c.name) like :name')
                        ->setParameter('name', '%' . mb_strtoupper($value) . '%');
                    break;
                case 'sort':
                    $query
                        ->andWhere('c.sort = :sort')
                        ->setParameter('sort', (int)$value);
                    break;
                case 'is_parent':
                    if ($value) {
                        $query->andWhere('c.parentCategory is null');
                    } else {
                        $query->andWhere('c.parentCategory is not null');
                    }
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
