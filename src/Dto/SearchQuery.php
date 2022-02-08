<?php

namespace App\Dto;

class SearchQuery
{
    protected int $page;
    protected int $pageItemCount;
    protected ?string $orderField;
    protected ?string $orderType;
    protected array $search = [];

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    public function getPageItemCount(): int
    {
        return $this->pageItemCount;
    }

    public function setPageItemCount(int $pageItemCount): self
    {
        $this->pageItemCount = $pageItemCount;
        return $this;
    }

    public function getOrderField(): ?string
    {
        return $this->orderField ?? null;
    }

    public function setOrderField(string $orderField): self
    {
        $this->orderField = $orderField;
        return $this;
    }

    public function getOrderType(): ?string
    {
        return $this->orderType ?? null;
    }

    public function setOrderType(string $orderType): self
    {
        $this->orderType = $orderType;
        return $this;
    }

    public function getSearch(): array
    {
        return $this->search;
    }

    public function setSearch(array $search): self
    {
        $this->search = $search;
        return $this;
    }
}
