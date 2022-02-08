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
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $durationType;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $durationValue;

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

    public function getDurationType(): string
    {
        return $this->durationType;
    }

    public function setDurationType(string $durationType): self
    {
        $this->durationType = $durationType;
        return $this;
    }

    public function getDurationValue(): string
    {
        return $this->durationValue;
    }

    public function setDurationValue(string $durationValue): self
    {
        $this->durationValue = $durationValue;
        return $this;
    }
}
