<?php

namespace App\Entity\Program;

use App\Entity\Category;
use App\Entity\Provider;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Program
{
    use IdTrait;
    use TimestampTrait;
    use Description;
    use Design;
    use Listeners;
    use Result;
    use Organization;
    use Terms;

    public const DURATION_HOURS = 'DURATION_HOURS';
    public const DURATION_DAYS = 'DURATION_DAYS';

    public const OTHER = 'OTHER';

    public const DESIGN_SIMPLE = 'DESIGN_SIMPLE';
    public const DESIGN_WORK = 'DESIGN_WORK';

    public const TRAINING_DATE_CALENDAR = 'TRAINING_DATE_CALENDAR';
    public const TRAINING_DATE_ANYTIME = 'TRAINING_DATE_ANYTIME';
    public const TRAINING_DATE_AS_THE_GROUP_FORM = 'TRAINING_DATE_AS_THE_GROUP_FORM';
    public const TRAINING_DATE_REQUEST = 'TRAINING_DATE_REQUEST';

    public const OCCUPATION_MODE_ANYTIME = 'OCCUPATION_MODE_ANYTIME';
    public const OCCUPATION_MODE_TIME = 'OCCUPATION_MODE_TIME';

    public const REAL_PRICE = 'REAL_PRICE';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    protected User $author;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $active;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    protected Collection $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\Teacher", mappedBy="program")
     */
    protected Collection $teachers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Provider", inversedBy="programs")
     */
    protected Collection $providers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramGallery", mappedBy="program")
     */
    protected Collection $gallery;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location")
     */
    protected Collection $locations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramRequest", mappedBy="program")
     */
    protected Collection $requests;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramQuestion", mappedBy="program")
     */
    protected Collection $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramReview", mappedBy="program")
     */
    protected Collection $reviews;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $additionalInfo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favoritePrograms", fetch="LAZY")
     */
    protected Collection $favoriteUsers;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->providers = new ArrayCollection();
        $this->gallery = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->favoriteUsers = new ArrayCollection();
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;
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

    public function getCategories()
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

    public function getTeachers()
    {
        return $this->teachers;
    }

    public function setTeachers(array $teachers): self
    {
        $this->teachers->clear();
        foreach ($teachers as $teacher) {
            if (!$this->teachers->contains($teacher)) {
                $this->teachers->add($teacher);
            }
        }
        return $this;
    }

    public function getProviders()
    {
        return $this->providers;
    }

    public function addProvider(Provider $provider): self
    {
        $this->providers->add($provider);
        return $this;
    }

    public function setProviders(array $providers): self
    {
        $this->providers->clear();
        foreach ($providers as $provider) {
            if (!$this->providers->contains($provider)) {
                $this->providers->add($provider);
            }
        }

        return $this;
    }

    public function getGallery()
    {
        return $this->gallery;
    }

    public function setGallery(array $gallery): self
    {
        $this->gallery->clear();
        foreach ($gallery as $item) {
            if (!$this->gallery->contains($item)) {
                $this->gallery->add($item);
            }
        }

        return $this;
    }

    public function getLocations()
    {
        return $this->locations;
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

    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function setRequests($requests): self
    {
        $this->requests = $requests;
        return $this;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function setQuestions($questions): self
    {
        $this->questions = $questions;
        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    public function getReviews()
    {
        return $this->reviews;
    }

    public function setReviews($reviews): self
    {
        $this->reviews = $reviews;
        return $this;
    }
}
