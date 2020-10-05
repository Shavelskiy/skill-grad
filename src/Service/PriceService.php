<?php

namespace App\Service;

use App\Entity\Service\ProgramService;

class PriceService
{
    public function getServicePrices(): array
    {
        return [
            ProgramService::HIGHLIGHT => 990,
            ProgramService::RAISE => 490,
            ProgramService::HIGHLIGHT_RISE => 1290,
        ];
    }

    public function getProAccountPrice(): int
    {
        return 1990;
    }
}
