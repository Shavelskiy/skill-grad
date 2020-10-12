<?php

namespace App\Entity\Content;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Faq
{
    use IdTrait;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $sort;

    /**
     * @ORM\Column(type="string")
     */
    protected string $title;

    /**
     * @ORM\Column(type="text")
     */
    protected string $content;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $active;

    public function getSort(): int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
