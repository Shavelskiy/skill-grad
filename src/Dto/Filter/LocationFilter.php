<?php

namespace App\Dto\Filter;

class LocationFilter
{
    protected ?int $id;
    protected ?string $name;
    protected ?string $type;

    protected function __construct()
    {
    }

    public static function createFromArray($array): self
    {
        return (new LocationFilter())
            ->setId((isset($array['id']) && (int)$array['id'] > 0) ? (int)$array['id'] : null)
            ->setName($array['name'] ?? null)
            ->setType((isset($array['type']) && !empty($array['type'])) ? $array['type'] : null);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return LocationFilter
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return LocationFilter
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     *
     * @return LocationFilter
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
