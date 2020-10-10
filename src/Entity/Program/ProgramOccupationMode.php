<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ProgramOccupationMode
{
    public const OCCUPATION_MODE_ANYTIME = 'anytime';
    public const OCCUPATION_MODE_TIME = 'time';
    public const OTHER = 'other';

    use IdTrait;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Program\Program", inversedBy="programOccupationMode")
     */
    protected Program $program;

    /**
     * @ORM\Column(type="string")
     */
    protected string $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?array $days;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $fromTime;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $toTime;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $otherValue;

    public function getProgram(): Program
    {
        return $this->program;
    }

    public function setProgram(Program $program): self
    {
        $this->program = $program;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function setDays(?array $days): self
    {
        $this->days = $days;
        return $this;
    }

    public function getFromTime(): ?string
    {
        return $this->fromTime;
    }

    public function setFromTime(?string $fromTime): self
    {
        $this->fromTime = $fromTime;
        return $this;
    }

    public function getToTime(): ?string
    {
        return $this->toTime;
    }

    public function setToTime(?string $toTime): self
    {
        $this->toTime = $toTime;
        return $this;
    }

    public function getOtherValue(): ?string
    {
        return $this->otherValue;
    }

    public function setOtherValue(?string $otherValue): self
    {
        $this->otherValue = $otherValue;
        return $this;
    }
}