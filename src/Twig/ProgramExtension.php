<?php

namespace App\Twig;

use App\Entity\Category;
use App\Entity\Program\Program;
use App\Repository\ProgramAdditionalRepository;
use App\Repository\ProgramFormatRepository;
use App\Repository\ProgramIncludeRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ProgramExtension extends AbstractExtension
{
    protected ProgramFormatRepository $programFormatRepository;
    protected ProgramIncludeRepository $programIncludeRepository;
    protected ProgramAdditionalRepository $programAdditionalRepository;

    public function __construct(
        ProgramFormatRepository $programFormatRepository,
        ProgramIncludeRepository $programIncludeRepository,
        ProgramAdditionalRepository $programAdditionalRepository
    ) {
        $this->programFormatRepository = $programFormatRepository;
        $this->programIncludeRepository = $programIncludeRepository;
        $this->programAdditionalRepository = $programAdditionalRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('programAdditional', [$this, 'programAdditional']),
            new TwigFunction('programCategories', [$this, 'programCategories']),
        ];
    }

    public function programAdditional(Program $program): array
    {
        return [
            'format' => $this->prepareProgramFormat($program->getFormat()),
            'design' => $this->prepareProgramDesign($program->getDesign()),
            'duration' => $this->prepareProgramDuration($program->getDuration()),
            'price' => $this->prepareProgramPrice($program->getPrice()),
            'discount' => $this->prepareProgramDiscount($program->getDiscount()),
            'term_of_payment' => $this->prepareTermOfPayment($program->getTermOfPayment()),
            'includes' => $this->prepareProgramIncludes($program->getIncludes()),
            'additional' => $this->prepareProgramAdditional($program->getAdditional()),
        ];
    }

    protected function prepareProgramFormat(array $data): string
    {
        if ($data['type'] === Program::OTHER) {
            return $data['value'];
        }

        return $this->programFormatRepository->find($data['value'])->getName();
    }

    protected function prepareProgramDesign(array $data): string
    {
        if ($data['type'] === Program::OTHER) {
            return $data['value'];
        }

        if ($data['type'] === Program::DESIGN_SIMPLE) {
            return sprintf('%s теории, %s практики', $data['value'][0], $data['value'][1]);
        }

        return 'Работа с наставником (мьютором, преподавателем)';
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

    protected function prepareTermOfPayment(array $data): ?array
    {
        if ($data['type'] === Program::OTHER) {
            return null;
        }

        return [
            'individual' => $data['individual']['active'] ? $data['individual']['value'] : false,
            'legal' => $data['legal']['active'] ? $data['legal']['value'] : false,
        ];
    }

    protected function prepareProgramIncludes(array $data): array
    {
        $result = [];

        foreach ($data['values'] as $value) {
            $result[] = $this->programIncludeRepository->find($value)->getTitle();
        }

        if (!empty($data['other_value'])) {
            $result[] = $data['other_value'];
        }

        return $result;
    }

    protected function prepareProgramAdditional(array $data): array
    {
        $result = [];

        foreach ($data['values'] as $value) {
            $result[] = $this->programAdditionalRepository->find($value)->getTitle();
        }

        if (!empty($data['other_value'])) {
            $result[] = $data['other_value'];
        }

        return $result;
    }

    public function programCategories(Program $program): array
    {
        $result = [];

        /** @var Category $category */
        foreach ($program->getCategories() as $category) {
            $parentCategory = $category->getParentCategory();

            if ($parentCategory === null) {
                continue;
            }

            if (!isset($result[$parentCategory->getId()])) {
                $result[$parentCategory->getId()] = [
                    'item' => $parentCategory,
                    'childItems' => [],
                ];
            }

            $result[$parentCategory->getId()]['childItems'][] = $category;
        }

        return $result;
    }
}
