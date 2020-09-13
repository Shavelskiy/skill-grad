<?php

namespace App\Twig;

use App\Entity\Category;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramRequest;
use App\Entity\User;
use App\Repository\ProgramFormatRepository;
use App\Repository\ProgramLevelRepository;
use App\Service\ProgramService;
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
            new TwigFunction('programAdditional', [$this, 'programAdditional']),
            new TwigFunction('programCategories', [$this, 'programCategories']),
            new TwigFunction('getProgramFilters', [$this, 'getProgramFilters']),
            new TwigFunction('hasRequest', [$this, 'hasRequest']),
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
}
