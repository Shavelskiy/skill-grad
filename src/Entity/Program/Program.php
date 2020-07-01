<?php

namespace App\Entity\Program;

use App\Entity\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Program
{
    use Description;
    use Design;
    use Listeners;
    use Result;
    use Organization;
    use Terms;
    use Iteraction;

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

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    private Collection $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\Teacher", mappedBy="program")
     */
    protected Collection $teachers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Provider")
     */
    private Collection $providers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramGallery", mappedBy="program")
     */
    private Collection $gallery;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location")
     */
    private Collection $locations;

    /**
     * @ORM\Column(type="string")
     */
    protected string $additionalInfo;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $updated;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->providers = new ArrayCollection();
        $this->gallery = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->createdAt = new DateTime();
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

    public function getAdditionalInfo(): string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $this->updated = new DateTime();
    }
}
