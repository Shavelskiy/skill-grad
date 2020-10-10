<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Organization
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $trainingDateType;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected ?array $trainingDateExtra;

    /**
     * @ORM\Column(type="json")
     */
    protected string $location;

    public function getTrainingDateType(): ?string
    {
        return $this->trainingDateType;
    }

    public function setTrainingDateType(?string $trainingDateType): self
    {
        $this->trainingDateType = $trainingDateType;
        return $this;
    }

    public function getTrainingDateExtra(): ?array
    {
        return $this->trainingDateExtra;
    }

    public function setTrainingDateExtra(?array $trainingDateExtra): self
    {
        $this->trainingDateExtra = $trainingDateExtra;
        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }
}
