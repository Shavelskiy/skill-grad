<?php

namespace App\Service;

use App\Entity\Program\Program;
use App\Repository\ProgramFormatRepository;

class ProgramService
{
    protected ProgramFormatRepository $programFormatRepository;

    public function __construct(
        ProgramFormatRepository $programFormatRepository
    ) {
        $this->programFormatRepository = $programFormatRepository;
    }

    public function prepareProgramCard(Program $program): array
    {
        return [
            'format' => $this->prepareProgramFormat($program->getFormat()),
            'duration' => $this->prepareProgramDuration($program->getDuration()),
            'price' => $this->prepareProgramPrice($program->getPrice()),
            'discount' => $this->prepareProgramDiscount($program->getDiscount()),
        ];
    }

    protected function prepareProgramFormat(array $data): string
    {
        if ($data['type'] === Program::OTHER) {
            return $data['value'];
        }

        return $this->programFormatRepository->find($data['value'])->getName();
    }

    protected function prepareProgramDuration(array $data): string
    {
        if ($data['type'] === Program::OTHER) {
            return $data['value'];
        }

        if ($data['type'] === Program::DURATION_HOURS) {
            return sprintf('%s ак. ч.', $data['value']);
        }

        if ($data['type'] === Program::DURATION_DAYS) {
            return sprintf('%s дней', $data['value']);
        }

        return '';
    }

    protected function prepareProgramPrice(array $data): ?array
    {
        if ($data['type'] !== Program::REAL_PRICE) {
            return null;
        }

        return [
            'individual' => $data['value'][0],
            'legal' => $data['value'][1] ?? $data['value'][0],
        ];
    }

    protected function prepareProgramDiscount(array $data): ?array
    {
        return null;

        return [
            '',
        ];
    }
}
