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
 * @ORM\Entity()
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

    public const DURATION_HOURS = 'DURATION_HOURS';
    public const DURATION_DAYS = 'DURATION_DAYS';

    public const OTHER = 'OTHER';

    public const DESIGN_SIMPLE = 'DESIGN_SIMPLE';
    public const DESIGN_WORK = 'DESIGN_WORK';

    public const TRAINING_DATE_CALENDAR = 'TRAINING_DATE_CALENDAR';
    public const TRAINING_DATE_ANYTIME = 'TRAINING_DATE_ANYTIME';
    public const TRAINING_DATE_AS_THE_GROUP_FORM = 'TRAINING_DATE_AS_THE_GROUP_FORM';
    public const TRAINING_DATE_REQUEST = 'TRAINING_DATE_REQUEST';

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\ProgramFormat", inversedBy="programs")
     */
    protected ProgramFormat $programFormat;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $formatOther;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Provider", inversedBy="programs")
     */
    protected Collection $providers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramGallery", mappedBy="program")
     */
    protected Collection $gallery;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $showPriceReduction;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected array $providerActions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\ActionFavoriteProvider")
     */
    protected ActionFavoriteProvider $actionFavoriteProvider;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Program\ProgramInclude", mappedBy="programs")
     */
    protected Collection $programIncludes;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service\ProgramService", mappedBy="program")
     */
    protected Collection $services;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramPayment", mappedBy="program")
     */
    protected Collection $payments;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Program\ProgramOccupationMode", mappedBy="program")
     */
    protected ProgramOccupationMode $programOccupationMode;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $otherInclude;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Program\ProgramAdditional", mappedBy="programs")
     */
    protected Collection $programAdditional;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $otherAdditional;

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
        $this->services = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->programIncludes = new ArrayCollection();
        $this->programAdditional = new ArrayCollection();
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

    public function getProgramFormat(): ProgramFormat
    {
        return $this->programFormat;
    }

    public function setProgramFormat(ProgramFormat $programFormat): self
    {
        $this->programFormat = $programFormat;
        return $this;
    }

    public function getFormatOther(): string
    {
        return $this->formatOther;
    }

    public function setFormatOther(string $formatOther): self
    {
        $this->formatOther = $formatOther;
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

    public function isShowPriceReduction(): bool
    {
        return $this->showPriceReduction;
    }

    public function setShowPriceReduction(bool $showPriceReduction): self
    {
        $this->showPriceReduction = $showPriceReduction;
        return $this;
    }

    public function getProviderActions(): array
    {
        return $this->providerActions;
    }

    public function setProviderActions(array $providerActions): self
    {
        $this->providerActions = $providerActions;
        return $this;
    }

    public function getActionFavoriteProvider(): ActionFavoriteProvider
    {
        return $this->actionFavoriteProvider;
    }

    public function setActionFavoriteProvider(ActionFavoriteProvider $actionFavoriteProvider): self
    {
        $this->actionFavoriteProvider = $actionFavoriteProvider;
        return $this;
    }

    public function getFavoriteUsers()
    {
        return $this->favoriteUsers;
    }

    public function setFavoriteUsers($favoriteUsers): self
    {
        $this->favoriteUsers = $favoriteUsers;
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

    public function getServices()
    {
        return $this->services;
    }

    public function setServices($services): self
    {
        $this->services = $services;
        return $this;
    }

    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function setPayments(Collection $payments): self
    {
        $this->payments = $payments;
        return $this;
    }

    public function addPayment(ProgramPayment $payment): self
    {
        $this->payments->add($payment);
        return $this;
    }

    public function getProgramOccupationMode(): ProgramOccupationMode
    {
        return $this->programOccupationMode;
    }

    public function setProgramOccupationMode(ProgramOccupationMode $programOccupationMode): self
    {
        $this->programOccupationMode = $programOccupationMode;
        return $this;
    }

    public function getProgramIncludes(): Collection
    {
        return $this->programIncludes;
    }

    public function setProgramIncludes(Collection $programIncludes): self
    {
        $this->programIncludes = $programIncludes;
        return $this;
    }

    public function getOtherInclude(): string
    {
        return $this->otherInclude;
    }

    public function setOtherInclude(string $otherInclude): self
    {
        $this->otherInclude = $otherInclude;
        return $this;
    }

    public function getProgramAdditional()
    {
        return $this->programAdditional;
    }

    public function setProgramAdditional($programAdditional): self
    {
        $this->programAdditional = $programAdditional;
        return $this;
    }

    public function getOtherAdditional(): string
    {
        return $this->otherAdditional;
    }

    public function setOtherAdditional(string $otherAdditional): self
    {
        $this->otherAdditional = $otherAdditional;
        return $this;
    }

}
