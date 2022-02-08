<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Listeners
{
    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected array $targetAudience;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\ProgramLevel")
     */
    protected ProgramLevel $level;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected array $preparation;

    public function getTargetAudience(): array
    {
        return $this->targetAudience;
    }

    public function setTargetAudience(array $targetAudience): self
    {
        $this->targetAudience = $targetAudience;
        return $this;
    }

    public function getLevel(): ProgramLevel
    {
        return $this->level;
    }

    public function setLevel(ProgramLevel $level): self
    {
        $this->level = $level;
        return $this;
    }

    public function getPreparation(): array
    {
        return $this->preparation;
    }

    public function setPreparation(array $preparation): self
    {
        $this->preparation = $preparation;
        return $this;
    }
}
