<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity()
 */
class Category
{
    use IdTrait;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $slug;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $sort;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="childCategories")
     */
    protected ?Category $parentCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parentCategory")
     * @ORM\OrderBy({"sort" = "ASC"})
     */
    protected PersistentCollection $childCategories;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    public function getParentCategory(): ?Category
    {
        return $this->parentCategory;
    }

    public function setParentCategory(?Category $parentCategory): self
    {
        $this->parentCategory = $parentCategory;
        return $this;
    }

    public function getChildCategories(): PersistentCollection
    {
        return $this->childCategories;
    }

    public function setChildCategories(PersistentCollection $childCategories): self
    {
        $this->childCategories = $childCategories;
        return $this;
    }
}
