<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Organization
{
    /**
     * @ORM\Column(type="json")
     */
    protected array $trainingDate;

    /**
     * @ORM\Column(type="json")
     */
    protected array $occupationMode;

    /**
     * @ORM\Column(type="json")
     */
    protected string $location;

    /**
     * @ORM\Column(type="json")
     */
    protected array $includes;

    public function getTrainingDate(): array
    {
        return $this->trainingDate;
    }

    public function setTrainingDate(array $trainingDate): self
    {
        $this->trainingDate = $trainingDate;
        return $this;
    }

    public function getOccupationMode(): array
    {
        return $this->occupationMode;
    }

    public function setOccupationMode(array $occupationMode): self
    {
        $this->occupationMode = $occupationMode;
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

    public function getIncludes(): array
    {
        return $this->includes;
    }

    public function setIncludes(array $includes): self
    {
        $this->includes = $includes;
        return $this;
    }
}
