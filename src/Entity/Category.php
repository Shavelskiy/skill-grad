<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity()
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $slug;

    /**
     * @ORM\Column(type="integer")
     */
    private int $sort;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="id")
     */
    private ?Category $parentCategory;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parentCategory")
     */
    private PersistentCollection $childCategories;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

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
