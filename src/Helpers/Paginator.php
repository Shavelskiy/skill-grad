<?php

namespace App\Helpers;

use App\Dto\PaginatorResult;
use Doctrine\ORM\QueryBuilder;

class Paginator
{
    private const DEFAULT_PAGE_ITEMS = 10;

    private QueryBuilder $query;
    private QueryBuilder $countQuery;
    private int $page = 1;
    private int $pageItems = self::DEFAULT_PAGE_ITEMS;
    private PaginatorResult $result;

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

    public function getCountField(): string
    {
        return $this->countField;
    }

    public function setCountField(string $countField): self
    {
        $this->countField = $countField;
        return $this;
    }

    public function setPageItems(int $pageItems): self
    {
        $this->pageItems = $pageItems;
        return $this;
    }

    public function getResult(): PaginatorResult
    {
        if (!isset($this->result)) {
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
                ->setTotalPageCount(ceil($totalCount / $this->pageItems));
        }

        return $this->result;
    }
}
