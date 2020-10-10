<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Design
{
    /**
     * @ORM\Column(type="text")
     */
    protected string $processDescription;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $designType;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected array $designValue;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected bool $knowledgeCheck;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $knowledgeCheckOther;

    /**
     * @ORM\Column(type="text")
     */
    protected string $advantages;

    public function getProcessDescription(): string
    {
        return $this->processDescription;
    }

    public function setProcessDescription(string $processDescription): self
    {
        $this->processDescription = $processDescription;
        return $this;
    }

    public function getDesignType(): string
    {
        return $this->designType;
    }

    public function setDesignType(string $designType): self
    {
        $this->designType = $designType;
        return $this;
    }

    public function getDesignValue(): array
    {
        return $this->designValue;
    }

    public function setDesignValue(array $designValue): self
    {
        $this->designValue = $designValue;
        return $this;
    }

    public function isKnowledgeCheck(): bool
    {
        return $this->knowledgeCheck;
    }

    public function setKnowledgeCheck(bool $knowledgeCheck): self
    {
        $this->knowledgeCheck = $knowledgeCheck;
        return $this;
    }

    public function getKnowledgeCheckOther(): ?string
    {
        return $this->knowledgeCheckOther;
    }

    public function setKnowledgeCheckOther(?string $knowledgeCheckOther): self
    {
        $this->knowledgeCheckOther = $knowledgeCheckOther;
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
