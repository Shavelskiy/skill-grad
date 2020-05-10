<?php

namespace App\Dto;

class Paginator
{
    protected array $items;
    protected int $currentPage;
    protected int $totalPageCount;

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function setCurrentPage(int $currentPage): self
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function getTotalPageCount(): int
    {
        return $this->totalPageCount;
    }

    public function setTotalPageCount(int $totalPageCount): self
    {
        $this->totalPageCount = $totalPageCount;

        return $this;
    }
}
