<?php

namespace App\Entity\Program;

use Doctrine\ORM\Mapping as ORM;

trait Terms
{
    /**
     * @ORM\Column(type="json")
     */
    protected array $price;

    /**
     * @ORM\Column(type="json")
     */
    protected array $oldPrice;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $showPriceReduction;

    /**
     * @ORM\Column(type="json")
     */
    protected array $discount;

    /**
     * @ORM\Column(type="simple_array")
     */
    protected array $providerActions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Program\ActionFavoriteProvider")
     */
    protected ActionFavoriteProvider $actionFavoriteProvider;

    public function getPrice(): array
    {
        return $this->price;
    }

    public function setPrice(array $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getOldPrice(): array
    {
        return $this->oldPrice;
    }

    public function setOldPrice(array $oldPrice): self
    {
        $this->oldPrice = $oldPrice;
        return $this;
    }

    public function isShowPriceReduction(): bool
    {
        return $this->showPriceReduction;
    }

    public function setShowPriceReduction(bool $showPriceReduction): self
    {
        $this->showPriceReduction = $showPriceReduction;
        return $this;
    }

    public function getDiscount(): array
    {
        return $this->discount;
    }

    public function setDiscount(array $discount): self
    {
        $this->discount = $discount;
        return $this;
    }

    public function getProviderActions(): array
    {
        return $this->providerActions;
    }

    public function setProviderActions(array $providerActions): self
    {
        $this->providerActions = $providerActions;
        return $this;
    }

    public function getActionFavoriteProvider(): ActionFavoriteProvider
    {
        return $this->actionFavoriteProvider;
    }

    public function setActionFavoriteProvider(ActionFavoriteProvider $actionFavoriteProvider): self
    {
        $this->actionFavoriteProvider = $actionFavoriteProvider;
        return $this;
    }
}
