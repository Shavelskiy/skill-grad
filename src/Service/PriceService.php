<?php

namespace App\Service;

use App\Entity\Service\ServicePrice;
use App\Repository\ServicePriceRepository;

class PriceService
{
    protected ServicePriceRepository $servicePriceRepository;

    public function __construct(
        ServicePriceRepository $servicePriceRepository
    ) {
        $this->servicePriceRepository = $servicePriceRepository;
    }

    public function getServicePrices(): array
    {
        $prices = [
            ServicePrice::PROGRAM_HIGHLIGHT => 0,
            ServicePrice::PROGRAM_RAISE => 0,
            ServicePrice::PROGRAM_HIGHLIGHT_RISE => 0,
        ];

        foreach ($this->servicePriceRepository->findBy(['type' => array_keys($prices)]) as $servicePrice) {
            $prices[$servicePrice->getType()] = $servicePrice->getPrice();
        }

        return $prices;
    }

    public function getProAccountPrice(): int
    {
        $servicePrice = $this->servicePriceRepository->findOneBy(['type' => ServicePrice::PRO_ACCOUNT]);

        return ($servicePrice !== null) ? $servicePrice->getPrice() : 0;
    }
}
