<?php

namespace App\Entity\Program;

use App\Entity\Upload;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Teacher
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Upload")
     */
    private ?Upload $photo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program")
     */
    private Program $program;

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

    public function getPhoto(): ?Upload
    {
        return $this->photo;
    }

    public function setPhoto(?Upload $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    public function getProgram(): Program
    {
        return $this->program;
    }

    public function setProgram(Program $program): self
    {
        $this->program = $program;
        return $this;
    }
}
