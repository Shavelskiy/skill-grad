<?php

namespace App\Repository\Content;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Content\Page;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
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
                case 'id':
                    $query
                        ->andWhere('p.id = :id')
                        ->setParameter('id', (int)$value);
                    break;
                case 'title':
                    $query
                        ->andWhere('upper(p.title) like :title')
                        ->setParameter('title', '%' . mb_strtoupper($value) . '%');
                    break;
                case 'slug':
                    $query
                        ->andWhere('p.slug = :slug')
                        ->setParameter('slug', $value);
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
