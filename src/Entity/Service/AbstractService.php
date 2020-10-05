<?php

namespace App\Entity\Service;

use App\Entity\Traits\IdTrait;
use App\Entity\Traits\TimestampTrait;
use App\Entity\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected DateTime $expireAt;

    /**
     * @ORM\Column(type="string")
     */
    protected string $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $number;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service\Document", mappedBy="service", cascade={"persist"})
     */
    protected Collection $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    abstract public function getTitle(): string;

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

    public function getNumber(): string
    {
        return $this->number ?? '';
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;
        return $this;
    }

    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function setDocuments(Collection $documents): self
    {
        $this->documents = $documents;
        return $this;
    }

    public function addDocument(Document $document): self
    {
        $this->documents->add($document);
        return $this;
    }
}
