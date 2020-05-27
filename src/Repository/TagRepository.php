<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Entity\Program;
use App\Entity\Tag;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;

class TagRepository extends ServiceEntityRepository
{
    protected const ORDABLE_FIELDS = ['id', 'sort', 'name'];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * @return mixed
     */
    public function findTagWithMaxSort()
    {
        try {
            return $this->createQueryBuilder('t')
                ->orderBy('t.sort', 'desc')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param Program $program
     * @param int $page
     * @param int $pageItems
     * @return PaginatorResult
     */
    public function getPaginatorItems(int $page, ?array $orders, int $pageItems = 5): PaginatorResult
    {
        $query = $this->createQueryBuilder('t');

        if ($orders !== null) {
            foreach ($orders as $field => $order) {
                if (!in_array($field, self::ORDABLE_FIELDS, true)) {
                    continue;
                }

                if ($order === null || !in_array($order, ['asc', 'desc'], true)) {
                    continue;
                }

                $query->addOrderBy("t.$field", $order);
            }
        }

        $query
            ->addOrderBy('t.sort', 'asc')
            ->addOrderBy('t.id', 'asc');

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($pageItems)
            ->setPage($page)
            ->getResult();
    }
}
