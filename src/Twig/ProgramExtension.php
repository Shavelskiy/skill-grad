<?php

namespace App\Twig;

use App\Entity\Category;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramAdditional;
use App\Entity\Program\ProgramOccupationMode;
use App\Entity\Program\ProgramRequest;
use App\Entity\User;
use App\Repository\ProgramFormatRepository;
use App\Repository\ProgramLevelRepository;
use App\Service\ProgramService;
use DateTime;
use function is_object;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ProgramExtension extends AbstractExtension
{
    protected ProgramFormatRepository $programFormatRepository;
    protected ProgramLevelRepository $programLevelRepository;
    protected ProgramService $programService;
    protected TokenStorageInterface $tokenStorage;

    public function __construct(
        ProgramFormatRepository $programFormatRepository,
        ProgramLevelRepository $programLevelRepository,
        ProgramService $programService,
        TokenStorageInterface $tokenStorage
    ) {
        $this->programFormatRepository = $programFormatRepository;
        $this->programLevelRepository = $programLevelRepository;
        $this->programService = $programService;
        $this->tokenStorage = $tokenStorage;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('programCategories', [$this, 'programCategories']),
            new TwigFunction('getProgramFilters', [$this, 'getProgramFilters']),
            new TwigFunction('hasRequest', [$this, 'hasRequest']),
            new TwigFunction('getAverageRating', [$this, 'getAverageRating']),
            new TwigFunction('isDiscount', [$this, 'isDiscount']),
            new TwigFunction('getDuration', [$this, 'getDuration']),
            new TwigFunction('getProgramPrice', [$this, 'getProgramPrice']),
            new TwigFunction('getOldProgramPrice', [$this, 'getOldProgramPrice']),
            new TwigFunction('getProgramDesign', [$this, 'getProgramDesign']),
            new TwigFunction('getTrainingDate', [$this, 'getTrainingDate']),
            new TwigFunction('getOccupationMode', [$this, 'getOccupationMode']),
            new TwigFunction('getAllAdditional', [$this, 'getAllAdditional']),
        ];
    }

    public function isDiscount(Program $program): bool
    {
        return $this->programService->isDiscount($program);
    }

    public function getDuration(Program $program): string
    {
        return $this->programService->getDuration($program);
    }

    public function getProgramPrice(Program $program): ?int
    {
        return $this->programService->getPrice($program);
    }

    public function getOldProgramPrice(Program $program): ?int
    {
        return $this->programService->getOldPrice($program);
    }

    public function getProgramDesign(Program $program): string
    {
        switch ($program->getDesignType()) {
            case Program::DESIGN_SIMPLE:
                return sprintf('%s %% теории, %s %% практики', $program->getDesignValue()[0], $program->getDesignValue()[1]);
            case Program::DESIGN_WORK:
                return 'Работа с наставником (тьютором, преподавателем)';
            default:
                return $program->getDesignValue()[0];
        }
    }

    public function getTrainingDate(Program $program): string
    {
        switch ($program->getTrainingDateType()) {
            case Program::TRAINING_DATE_CALENDAR:
                $dates = [];

                foreach ($program->getTrainingDateExtra() as $date) {
                    $dateObject = new DateTime($date);
                    $dates[] = sprintf('%s %s', $dateObject->format('d'), DateExtension::MONTHS[$dateObject->format('m') - 1]);
                }

                return implode(', ', $dates);
            case Program::TRAINING_DATE_ANYTIME:
                return 'В любое время';
            case Program::TRAINING_DATE_AS_THE_GROUP_FORM:
                return 'По мере формирования группы';
            case Program::TRAINING_DATE_REQUEST:
                return 'Направить запрос';
        }

        return '';
    }

    public function getOccupationMode(Program $program): string
    {
        $occupationMode = $program->getProgramOccupationMode();

        if ($occupationMode === null) {
            return '';
        }

        switch ($occupationMode->getType()) {
            case ProgramOccupationMode::OCCUPATION_MODE_ANYTIME:
                return 'В любое удобное время';
            case ProgramOccupationMode::OCCUPATION_MODE_TIME:
                $days = [];

                foreach ($occupationMode->getDays() as $day) {
                    $days[] = DateExtension::DAY_OF_WEEK[$day - 1];
                }

                return sprintf('%s с %s до %s', implode(', ', $days), $occupationMode->getFromTime(), $occupationMode->getToTime());
            case ProgramOccupationMode::OTHER:
                return $occupationMode->getOtherValue();
        }

        return '';
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

    public function hasRequest(int $programId): bool
    {
        if (($token = $this->tokenStorage->getToken()) === null) {
            return false;
        }

        /** @var User $user */
        if (!is_object($user = $token->getUser())) {
            return false;
        }

        /** @var ProgramRequest $programRequest */
        foreach ($user->getProgramRequests() as $programRequest) {
            if ($programRequest->getProgram()->getId() === $programId) {
                return true;
            }
        }

        return false;
    }

    public function getAverageRating(Program $program): float
    {
        return $this->programService->getAverageRating($program);
    }

    public function getAllAdditional(Program $program): string
    {
        $additional = $program->getProgramAdditional()->map(fn(ProgramAdditional $programAdditional) => $programAdditional->getTitle())->toArray();

        if (!empty($program->getOtherAdditional())) {
            $additional[] = $program->getOtherAdditional();
        }

        return implode(', ', $additional);
    }
}
