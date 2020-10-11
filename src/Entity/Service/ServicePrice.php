<?php

namespace App\Entity\Service;

use App\Entity\Traits\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ServicePrice
{
    public const PROGRAM_HIGHLIGHT = 'highlight';
    public const PROGRAM_RAISE = 'raise';
    public const PROGRAM_HIGHLIGHT_RISE = 'highlight_raise';

    public const PRO_ACCOUNT = 'pro_account';

    use IdTrait;

    /**
     * @ORM\Column(type="string")
     */
    protected string $type;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $price;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }
}