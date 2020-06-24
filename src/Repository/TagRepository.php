<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Entity\Tag;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class TagRepository extends ServiceEntityRepository
{
    protected const ORDABLE_FIELDS = ['id', 'sort', 'name'];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function getPaginatorItems(int $page, ?array $order, int $pageItems): PaginatorResult
    {
        $query = $this->createQueryBuilder('t');

        if (!empty($order)) {
            $orderField = array_key_first($order);

            if (in_array($orderField, self::ORDABLE_FIELDS, true)) {
                $orderType = $order[$orderField];

                $query->addOrderBy("t.$orderField", ($orderType === 'asc') ? 'asc' : 'desc');
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
