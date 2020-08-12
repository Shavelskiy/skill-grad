<?php

namespace App\Entity;

use App\Entity\Traits\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use RuntimeException;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RubricRepository")
 */
class Location
{
    use IdTrait;

    public const TYPE_COUNTRY = 'country';
    public const TYPE_REGION = 'region';
    public const TYPE_CITY = 'city';

    public const TYPES = [
        self::TYPE_COUNTRY,
        self::TYPE_REGION,
        self::TYPE_CITY,
    ];

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $code;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $showInList = false;

    /**
     * @ORM\Column(type="integer")
     */
    protected int $sort = 100;

    /**
     * @ORM\Column(type="string")
     */
    protected string $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="childLocations")
     * @ORM\JoinColumn(nullable=true)
     */
    protected ?Location $parentLocation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="parentLocation")
     */
    protected Collection $childLocations;

    public function __construct()
    {
        $this->childLocations = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function isShowInList(): bool
    {
        return $this->showInList;
    }

    public function setShowInList(bool $showInList): self
    {
        $this->showInList = $showInList;
        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;
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

    public function getParentLocation(): ?Location
    {
        return $this->parentLocation;
    }

    public function setParentLocation(?Location $parentLocation): self
    {
        $this->parentLocation = $parentLocation;
        return $this;
    }

    public function getChildLocations()
    {
        return $this->childLocations;
    }

    public function setChildLocations($childLocations): self
    {
        $this->childLocations = $childLocations;
        return $this;
    }

    public function hasChildType(): bool
    {
        return (isset($this->type)) && $this->type !== self::TYPE_CITY;
    }

    public function getChildType(): string
    {
        switch ($this->getType()) {
            case self::TYPE_COUNTRY:
                return self::TYPE_REGION;
                break;
            case self::TYPE_REGION:
                return self::TYPE_CITY;
                break;
        }

        throw new RuntimeException('Location could not has child location');
    }
}
