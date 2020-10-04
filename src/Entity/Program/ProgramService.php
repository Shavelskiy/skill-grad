<?php

namespace App\Entity\Program;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class ProgramService
{
    public const HIGHLIGHT = 'highlight';
    public const RAISE = 'raise';
    public const HIGHLIGHT_RISE = 'highlight_raise';

    public const TYPES = [
        self::HIGHLIGHT,
        self::RAISE,
        self::HIGHLIGHT_RISE,
    ];

    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\Program", inversedBy="services")
     */
    protected Program $program;

    /**
     * @ORM\Column(type="string")
     */
    protected string $type;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $active = true;

    /**
     * @ORM\Column(type="float")
     */
    protected float $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="programServices")
     */
    protected User $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $expireAt;

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

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getExpireAt(): DateTime
    {
        return $this->expireAt;
    }

    public function setExpireAt(DateTime $expireAt): self
    {
        $this->expireAt = $expireAt;
        return $this;
    }
}
