<?php

namespace App\Entity\Program;

use App\Entity\Upload;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProgramGallery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Upload")
     */
    protected Upload $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program")
     */
    protected Program $program;

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

    public function getImage(): Upload
    {
        return $this->image;
    }

    public function setImage(Upload $image): self
    {
        $this->image = $image;
        return $this;
    }
}
