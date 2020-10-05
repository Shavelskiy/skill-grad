<?php

namespace App\Entity\Service;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="service")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap({
 *     "program_service" = "ProgramService",
 *     "provider_service" = "ProviderService",
 * })
 *
 * @ORM\HasLifecycleCallbacks()
 */
abstract class AbstractService
{
    use IdTrait;
    use TimestampTrait;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $active = true;

    /**
     * @ORM\Column(type="float")
     */
    protected float $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="services")
     */
    protected User $user;

    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $expireAt;

    /**
     * @ORM\Column(type="string")
     */
    protected string $type;

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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }
}
