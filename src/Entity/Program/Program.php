<?php

namespace App\Entity\Program;

use App\Entity\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 */
class Program
{
    use Description;
    use Design;
    use Listeners;
    use Result;
    use Organization;
    use Terms;
    use Iteraction;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Provider")
     */
    private Collection $providers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program\ProgramGallery", mappedBy="program")
     */
    private Collection $gallery;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location")
     */
    private Collection $locations;

    /**
     * @ORM\Column(type="string")
     */
    protected string $additionalInfo;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $updated;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->providers = new ArrayCollection();
        $this->gallery = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;
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

    public function getProviders()
    {
        return $this->providers;
    }

    public function setProviders($providers): self
    {
        $this->providers = $providers;
        return $this;
    }

    public function getGallery()
    {
        return $this->gallery;
    }

    public function setGallery($gallery): self
    {
        $this->gallery = $gallery;
        return $this;
    }

    public function getLocations()
    {
        return $this->locations;
    }

    public function setLocations($locations): self
    {
        $this->locations = $locations;
        return $this;
    }

    public function getAdditionalInfo(): string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    public function setUpdated(DateTime $updated): self
    {
        $this->updated = $updated;
        return $this;
    }
}
