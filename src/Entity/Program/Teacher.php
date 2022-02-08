<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use App\Entity\Upload;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Teacher
{
    use IdTrait;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Upload")
     */
    protected ?Upload $photo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program", inversedBy="teachers")
     */
    protected Program $program;

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
        return $this->photo ?? null;
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
