<?php

namespace App\Service;

use App\Entity\Program\Program;
use App\Entity\Program\ProgramService as ProgramServiceEntity;

class ProgramServicesService
{
    public function isProgramHighLight(Program $program): bool
    {
        return !$program
            ->getServices()
            ->filter(fn(ProgramServiceEntity $programService) => $programService->isActive() && in_array($programService->getType(), [ProgramServiceEntity::HIGHLIGHT, ProgramServiceEntity::HIGHLIGHT_RISE], true))
            ->isEmpty();
    }

    public function isProgramRaise(Program $program): bool
    {
        return !$program
            ->getServices()
            ->filter(fn(ProgramServiceEntity $programService) => $programService->isActive() && in_array($programService->getType(), [ProgramServiceEntity::RAISE, ProgramServiceEntity::HIGHLIGHT_RISE], true))
            ->isEmpty();
    }
}
