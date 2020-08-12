<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Description
{
    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(type="text")
     */
    protected string $annotation;

    /**
     * @ORM\Column(type="text")
     */
    protected string $detailText;

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
