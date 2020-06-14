<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 */
class Program
{
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
    private User $mainProvider;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category")
     */
    private array $categories;

    /**
     * @ORM\Column(type="text")
     */
    private string $annotation;

    /**
     * @ORM\Column(type="text")
     */
    protected string $detailText;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Teacher", mappedBy="program")
     */
    protected array $teachers;

    /**
     * @ORM\Column(type="json")
     */
    protected array $duration;

    /**
     * @ORM\Column(type="json")
     */
    protected array $format;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgramRequest", mappedBy="program")
     */
    private array $requests;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProgramQuestion", mappedBy="program")
     */
    private array $questions;

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

    public function getMainProvider(): User
    {
        return $this->mainProvider;
    }

    public function setMainProvider(User $mainProvider): self
    {
        $this->mainProvider = $mainProvider;
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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function getAnnotation(): string
    {
        return $this->annotation;
    }

    public function setAnnotation(string $annotation): self
    {
        $this->annotation = $annotation;
        return $this;
    }

    public function getDetailText(): string
    {
        return $this->detailText;
    }

    public function setDetailText(string $detailText): self
    {
        $this->detailText = $detailText;
        return $this;
    }

    public function getTeachers(): array
    {
        return $this->teachers;
    }

    public function setTeachers(array $teachers): self
    {
        $this->teachers = $teachers;
        return $this;
    }

    public function getDuration(): array
    {
        return $this->duration;
    }

    public function setDuration(array $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getFormat(): array
    {
        return $this->format;
    }

    public function setFormat(array $format): self
    {
        $this->format = $format;
        return $this;
    }

    public function getRequests(): array
    {
        return $this->requests;
    }

    public function setRequests(array $requests): self
    {
        $this->requests = $requests;
        return $this;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function setQuestions(array $questions): self
    {
        $this->questions = $questions;
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

    public function setUpdated(DateTime $updated): self
    {
        $this->updated = $updated;
        return $this;
    }
}
