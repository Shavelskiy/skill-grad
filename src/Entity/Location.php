<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RubricRepository")
 */
class Location
{
    public const TYPE_COUNTRY = 'country';
    public const TYPE_REGION = 'region';
    public const TYPE_CITY = 'city';

    public const TYPES = [
        self::TYPE_COUNTRY,
        self::TYPE_REGION,
        self::TYPE_CITY,
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $sort;

    /**
     * @ORM\Column(type="string")
     */
    private string $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Location $parentLocation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Location
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return null|Location
     */
    public function getParentLocation(): ?Location
    {
        return $this->parentLocation;
    }

    /**
     * @param Location $parentLocation
     * @return Location
     */
    public function setParentLocation(Location $parentLocation): self
    {
        $this->parentLocation = $parentLocation;
        return $this;
    }
}
