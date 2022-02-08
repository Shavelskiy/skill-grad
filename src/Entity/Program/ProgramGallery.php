<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use App\Entity\Upload;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProgramGallery
{
    use IdTrait;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Upload")
     */
    protected Upload $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program", inversedBy="gallery")
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
