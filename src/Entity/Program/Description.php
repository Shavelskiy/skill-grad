<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Description
{
    /**
     * @ORM\Column(type="string")
     */
    private string $name;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Program\Teacher", mappedBy="program")
     */
    protected array $teachers;

    /**
     * @ORM\Column(type="json")
     */
    protected array $duration;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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
}
