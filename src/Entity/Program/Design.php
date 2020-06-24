<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Design
{
    /**
     * @ORM\Column(type="json")
     */
    protected array $format;

    /**
     * @ORM\Column(type="text")
     */
    protected string $processDescription;

    /**
     * @ORM\Column(type="json")
     */
    protected array $design;

    /**
     * @ORM\Column(type="json")
     */
    protected string $knowledgeCheck;

    /**
     * @ORM\Column(type="json")
     */
    protected array $additional;

    /**
     * @ORM\Column(type="json")
     */
    protected string $advantages;

    public function getFormat(): array
    {
        return $this->format;
    }

    public function setFormat(array $format): self
    {
        $this->format = $format;
        return $this;
    }

    public function getProcessDescription(): string
    {
        return $this->processDescription;
    }

    public function setProcessDescription(string $processDescription): self
    {
        $this->processDescription = $processDescription;
        return $this;
    }

    public function getDesign(): array
    {
        return $this->design;
    }

    public function setDesign(array $design): self
    {
        $this->design = $design;
        return $this;
    }

    public function getKnowledgeCheck(): string
    {
        return $this->knowledgeCheck;
    }

    public function setKnowledgeCheck(string $knowledgeCheck): self
    {
        $this->knowledgeCheck = $knowledgeCheck;
        return $this;
    }

    public function getAdditional(): array
    {
        return $this->additional;
    }

    public function setAdditional(array $additional): self
    {
        $this->additional = $additional;
        return $this;
    }

    public function getAdvantages(): string
    {
        return $this->advantages;
    }

    public function setAdvantages(string $advantages): self
    {
        $this->advantages = $advantages;
        return $this;
    }
}
