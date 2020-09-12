<?php

namespace App\Twig;

use App\Entity\Category;
use App\Entity\Program\Program;
use App\Repository\ProgramFormatRepository;
use App\Repository\ProgramLevelRepository;
use App\Service\ProgramService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ProgramExtension extends AbstractExtension
{
    protected ProgramFormatRepository $programFormatRepository;
    protected ProgramLevelRepository $programLevelRepository;
    protected ProgramService $programService;

    public function __construct(
        ProgramFormatRepository $programFormatRepository,
        ProgramLevelRepository $programLevelRepository,
        ProgramService $programService
    ) {
        $this->programFormatRepository = $programFormatRepository;
        $this->programLevelRepository = $programLevelRepository;
        $this->programService = $programService;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('programAdditional', [$this, 'programAdditional']),
            new TwigFunction('programCategories', [$this, 'programCategories']),
            new TwigFunction('getProgramFilters', [$this, 'getProgramFilters']),
        ];
    }

    public function programAdditional(Program $program): array
    {
        return $this->programService->programAdditional($program);
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

    public function getProgramFilters(): array
    {
        return [
            'formats' => $this->programFormatRepository->findAll(),
            'levels' => $this->programLevelRepository->findAll(),
        ];
    }
}
