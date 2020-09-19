<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Provider
{
    use IdTrait;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="provider")
     */
    protected ?User $user;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected string $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $externalLink;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    protected bool $proAccount = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Upload")
     */
    protected ?Upload $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    protected Collection $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     * @ORM\JoinTable(name="provider_categroy_additions")
     */
    protected Collection $additionalCategories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location")
     */
    protected Collection $locations;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Program\Program", mappedBy="providers")
     */
    protected Collection $programs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ProviderRequisites", mappedBy="provider", cascade={"persist", "remove"}, fetch="EAGER")
     */
    protected ?ProviderRequisites $providerRequisites;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favoriteProviders")
     */
    protected Collection $favoriteUsers;

    public function __construct()
    {
        $this->additionalCategories = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->locations = new ArrayCollection();
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

    public function getExternalLink(): ?string
    {
        return $this->externalLink;
    }

    public function setExternalLink(?string $externalLink): self
    {
        $this->externalLink = $externalLink;
        return $this;
    }

    public function isProAccount(): bool
    {
        return $this->proAccount;
    }

    public function setProAccount(bool $proAccount): self
    {
        $this->proAccount = $proAccount;
        return $this;
    }

    public function getImage(): ?Upload
    {
        return $this->image;
    }

    public function setImage(?Upload $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories->clear();
        foreach ($categories as $category) {
            if (!$this->categories->contains($category)) {
                $this->categories->add($category);
            }
        }

        return $this;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function getAdditionalCategories(): Collection
    {
        return $this->additionalCategories;
    }

    public function setAdditionalCategories(array $categories): self
    {
        $this->additionalCategories->clear();
        foreach ($categories as $category) {
            if (!$this->additionalCategories->contains($category)) {
                $this->additionalCategories->add($category);
            }
        }

        return $this;
    }

    public function addAdditionalCategory(Category $category): self
    {
        if (!$this->additionalCategories->contains($category)) {
            $this->additionalCategories->add($category);
        }

        return $this;
    }

    public function getLocations(): array
    {
        return $this->locations->toArray();
    }

    public function setLocations(array $locations): self
    {
        $this->locations->clear();
        foreach ($locations as $location) {
            if (!$this->locations->contains($location)) {
                $this->locations->add($location);
            }
        }

        return $this;
    }

    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function setPrograms(Collection $programs): self
    {
        $this->programs = $programs;
        return $this;
    }

    public function getProviderRequisites(): ?ProviderRequisites
    {
        return $this->providerRequisites;
    }

    public function setProviderRequisites(?ProviderRequisites $providerRequisites): self
    {
        $this->providerRequisites = $providerRequisites;
        return $this;
    }

    public function getFavoriteUsers(): Collection
    {
        return $this->favoriteUsers;
    }

    public function setFavoriteUsers(Collection $favoriteUsers): self
    {
        $this->favoriteUsers = $favoriteUsers;
        return $this;
    }
}
