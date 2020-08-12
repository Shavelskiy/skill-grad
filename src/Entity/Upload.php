<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Upload
{
    use IdTrait;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPublicPath(): string
    {
        return '/upload/' . $this->getName();
    }
}
