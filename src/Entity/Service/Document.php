<?php

namespace App\Entity\Service;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Document
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service\AbstractService", inversedBy="documents", cascade={"persist"})
     */
    protected AbstractService $service;

    /**
     * @ORM\Column(type="string")
     */
    protected string $path;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    public function getService(): AbstractService
    {
        return $this->service;
    }

    public function setService(AbstractService $service): self
    {
        $this->service = $service;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;
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
}
