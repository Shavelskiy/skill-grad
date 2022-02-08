<?php

namespace App\Helpers;

use App\Dto\PaginatorResult;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;

class Paginator
{
    protected QueryBuilder $query;
    protected QueryBuilder $countQuery;
    protected int $page = 1;
    protected int $pageItems;
    protected ?PaginatorResult $result = null;

    public function setQuery(QueryBuilder $query): self
    {
        $this->query = $query;
        return $this;
    }

    public function setCountQuery(QueryBuilder $countQuery): self
    {
        $this->countQuery = $countQuery;
        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    public function getPageItems(): int
    {
        return $this->pageItems;
    }

    public function setPageItems(int $pageItems): self
    {
        $this->pageItems = $pageItems;
        return $this;
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getResult(): PaginatorResult
    {
        if ($this->result === null) {
            $items = (clone $this->query)
                ->setFirstResult(($this->page - 1) * $this->pageItems)
                ->setMaxResults($this->pageItems)
                ->getQuery()
                ->getResult();

            $totalCount = (clone $this->query)
                ->resetDQLPart('orderBy')
                ->select('count(' . current($this->query->getRootAliases()) . '.id)')
                ->getQuery()
                ->getSingleScalarResult();

            return (new PaginatorResult())
                ->setItems($items)
                ->setCurrentPage($this->page)
                ->setTotalPageCount((int)ceil($totalCount / $this->pageItems));
        }

        return $this->result;
    }
}
