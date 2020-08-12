<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ActionFavoriteProvider
{
    use IdTrait;

    /**
     * @ORM\Column(type="float")
     */
    protected float $firstDiscount;

    /**
     * @ORM\Column(type="float")
     */
    protected float $discount;

    public function getFirstDiscount(): float
    {
        return $this->firstDiscount;
    }

    public function setFirstDiscount(float $firstDiscount): self
    {
        $this->firstDiscount = $firstDiscount;
        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;
        return $this;
    }
}
