<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Provider
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="provider")
     */
    private ?User $user;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private string $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     * @ORM\JoinTable(name="provider_categroy_group")
     */
    private Collection $categoryGroups;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    private Collection $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location")
     */
    private Collection $locations;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ProviderRequisites", mappedBy="prover")
     */
    private ProviderRequisites $providerRequisites;


    public function __construct()
    {
        $this->categoryGroups = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCategoryGroups(): array
    {
        return $this->categoryGroups->toArray();
    }

    public function setCategoryGroups(array $categoryGroups): self
    {
        foreach ($categoryGroups as $categoryGroup) {
            if (!$this->categoryGroups->contains($categoryGroup)) {
                $this->categoryGroups->add($categoryGroup);
            }
        }

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories->toArray();
    }

    public function setCategories(array $categories): self
    {
        foreach ($categories as $category) {
            if (!$this->categories->contains($category)) {
                $this->categories->add($category);
            }
        }

        return $this;
    }

    public function getLocations(): array
    {
        return $this->locations->toArray();
    }

    public function setLocations(Collection $locations): self
    {
        foreach ($locations as $location) {
            if (!$this->locations->contains($location)) {
                $this->categories->add($location);
            }
        }

        return $this;
    }

    public function getProviderRequisites(): ProviderRequisites
    {
        return $this->providerRequisites;
    }

    public function setProviderRequisites(ProviderRequisites $providerRequisites): self
    {
        $this->providerRequisites = $providerRequisites;
        return $this;
    }
}
