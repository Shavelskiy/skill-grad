<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findMainPageArticles(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.active = :active')
            ->andWhere('a.showOnMain = :showOnMain')
            ->setParameters([
                'active' => true,
                'showOnMain' => true,
            ])
            ->orderBy('a.sort', 'asc')
            ->getQuery()
            ->getResult();
    }

    public function findUserArticles(User $user): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.author = :author')
            ->setParameter('author', $user)
            ->orderBy('a.sort', 'asc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[]
     */
    public function findCategoriesArticles(Category $category, int $limit): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.category = :category')
            ->andWhere('a.active = :active')
            ->setParameters([
                'category' => $category,
                'active' => true,
            ])
            ->orderBy('a.createdAt', 'desc')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getPaginatorResult(SearchQuery $searchQuery): PaginatorResult
    {
        $query = $this->createQueryBuilder('a');

        if ($searchQuery->getOrderField() !== null) {
            $query->addOrderBy('a.' . $searchQuery->getOrderField(), $searchQuery->getOrderType());
        }

        foreach ($searchQuery->getSearch() as $field => $value) {
            switch ($field) {
                case 'id':
                    $query
                        ->andWhere('a.id = :id')
                        ->setParameter('id', (int)$value);
                    break;
                case 'category':
                    $query
                        ->andWhere('a.category = :category')
                        ->setParameter('category', $value);
                    break;
                case 'slug':
                    $query
                        ->andWhere('slug like :slug')
                        ->setParameter('slug', "%$value%");
                    break;
                case 'sort':
                    $query
                        ->andWhere('a.sort = :sort')
                        ->setParameter('sort', (int)$value);
                    break;
                case 'active':
                    $query
                        ->andWhere('a.active = :active')
                        ->setParameter('active', $value);
                    break;
                case 'showOnMain':
                    $query
                        ->andWhere('a.showOnMain = :showOnMain')
                        ->setParameter('showOnMain', $value);
                    break;
                case 'favoriteUsers':
                    $query
                        ->innerJoin('a.favoriteUsers', 'fu')
                        ->andWhere('fu = :user')
                        ->setParameter('user', $value);
                    break;
            }
        }

        $query
            ->addOrderBy('a.sort', 'asc')
            ->addOrderBy('a.id', 'asc');

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($searchQuery->getPageItemCount())
            ->setPage($searchQuery->getPage())
            ->getResult();
    }

    public function findPopularAuthors(): array
    {
        return $this
            ->createQueryBuilder('a')
            ->join('a.ratings', 'r')
            ->join('a.author', 'u')
            ->select('u.id, count(u.id) as total_count')
            ->groupBy('u.id')
            ->orderBy('total_count', 'desc')
            ->andWhere('r.like = true')
            ->setFirstResult(10)
            ->getQuery()
            ->getResult();
    }
}
