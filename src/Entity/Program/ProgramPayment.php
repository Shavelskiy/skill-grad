<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ProgramPayment
{
    public const LEGAL_ENTITY_TYPE = 'legalEntity';
    public const INDIVIDUAL_TYPE = 'individual';

    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program", inversedBy="payments")
     */
    protected Program $program;

    /**
     * @ORM\Column(type="string")
     */
    protected string $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $oldPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $discount;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected ?string $termOfPayment;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getOldPrice(): ?int
    {
        return $this->oldPrice;
    }

    public function setOldPrice(?int $oldPrice): self
    {
        $this->oldPrice = $oldPrice;
        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    public function getTermOfPayment(): ?string
    {
        return $this->termOfPayment;
    }

    public function setTermOfPayment(?string $termOfPayment): self
    {
        $this->termOfPayment = $termOfPayment;
        return $this;
    }
}
