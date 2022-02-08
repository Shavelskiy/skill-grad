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

    public const UPLOAD_PATH = '/upload';

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
        $parts = explode('-', $this->getName());

        return sprintf('%s/%s/%s/%s/%s',
            self::UPLOAD_PATH,
            substr($parts[0], 0, 3),
            substr($parts[1], 0, 3),
            substr($parts[2], 0, 3),
            $this->getName()
        );
    }
}
