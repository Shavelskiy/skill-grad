<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Category;
use App\Entity\Program\Program;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Program|null find($id, $lockMode = null, $lockVersion = null)
 * @method Program|null findOneBy(array $criteria, array $orderBy = null)
 * @method Program[]    findAll()
 * @method Program[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getPaginatorResult(SearchQuery $searchQuery): PaginatorResult
    {
        $query = $this->createQueryBuilder('p');

        if ($searchQuery->getOrderField() !== null) {
            $query->addOrderBy('p.' . $searchQuery->getOrderField(), $searchQuery->getOrderType());
        }

        $query
            ->addOrderBy('p.id', 'asc');

        foreach ($searchQuery->getSearch() as $field => $value) {
            switch ($field) {
                case 'active':
                    $query
                        ->andWhere('p.active = :active')
                        ->setParameter('active', $value);
                    break;
                case 'author':
                    $query
                        ->andWhere('p.author = :author')
                        ->setParameter('author', $value);
                    break;
                case 'favoriteUsers':
                    $query
                        ->innerJoin('p.favoriteUsers', 'fu')
                        ->andWhere('fu = :user')
                        ->setParameter('user', $value);
                    break;
            }
        }

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($searchQuery->getPageItemCount())
            ->setPage($searchQuery->getPage())
            ->getResult();
    }

    public function getNewCategoryPrograms(Category $category): array
    {
        return $this
            ->createQueryBuilder('p')
            ->join('p.categories', 'c')
            ->orderBy('p.createdAt', 'desc')
            ->andWhere('c.parentCategory = :category')
            ->setParameter('category', $category)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
