<?php

namespace App\Repository\Content;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Content\Faq;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Faq|null find($id, $lockMode = null, $lockVersion = null)
 * @method Faq|null findOneBy(array $criteria, array $orderBy = null)
 * @method Faq[]    findAll()
 * @method Faq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faq::class);
    }

    /**
     * @return Faq[]
     */
    public function findActiveItems(string $search): array
    {
        $query = $this
            ->createQueryBuilder('f')
            ->andWhere('f.active = :active')
            ->setParameter('active', true)
            ->orderBy('f.sort', 'asc');

        if (!empty($search)) {
            $query
                ->andWhere('upper(f.title) like :title')
                ->setParameter('title', '%' . mb_strtoupper($search) . '%');
        }

        return $query
            ->getQuery()
            ->getResult();
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
            ->addOrderBy('f.id', 'asc')
            ->addOrderBy('f.sort', 'asc');

        foreach ($searchQuery->getSearch() as $field => $value) {
            switch ($field) {
                case 'id':
                    $query
                        ->andWhere('f.id = :id')
                        ->setParameter('id', (int)$value);
                    break;
                case 'title':
                    $query
                        ->andWhere('upper(f.title) like :title')
                        ->setParameter('title', '%' . mb_strtoupper($value) . '%');
                    break;
                case 'sort':
                    $query
                        ->andWhere('f.sort = :sort')
                        ->setParameter('sort', (int)$value);
                    break;
                case 'active':
                    $query
                        ->andWhere('f.active = :active')
                        ->setParameter('active', $value);
            }
        }

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($searchQuery->getPageItemCount())
            ->setPage($searchQuery->getPage())
            ->getResult();
    }
}
