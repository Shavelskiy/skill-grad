<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Program\ProgramAdditional;
use App\Entity\Program\ProgramFormat;
use App\Entity\Program\ProgramInclude;
use App\Entity\Program\ProgramLevel;
use App\Entity\Provider;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use App\Repository\ProgramAdditionalRepository;
use App\Repository\ProgramFormatRepository;
use App\Repository\ProgramIncludeRepository;
use App\Repository\ProgramLevelRepository;
use App\Repository\ProviderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/program-form")
 *
 * @IsGranted("ROLE_PROVIDER")
 */
class ProgramFormController extends AbstractController
{
    protected CategoryRepository $categoryRepository;
    protected ProgramFormatRepository $programFormatRepository;
    protected ProgramAdditionalRepository $programAdditionalRepository;
    protected ProgramLevelRepository $programLevelRepository;
    protected ProgramIncludeRepository $programIncludeRepository;
    protected ProviderRepository $providerRepository;
    protected LocationRepository $locationRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProgramFormatRepository $programFormatRepository,
        ProgramAdditionalRepository $programAdditionalRepository,
        ProgramLevelRepository $programLevelRepository,
        ProgramIncludeRepository $programIncludeRepository,
        ProviderRepository $providerRepository,
        LocationRepository $locationRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->programFormatRepository = $programFormatRepository;
        $this->programAdditionalRepository = $programAdditionalRepository;
        $this->programLevelRepository = $programLevelRepository;
        $this->programIncludeRepository = $programIncludeRepository;
        $this->providerRepository = $providerRepository;
        $this->locationRepository = $locationRepository;
    }

    /**
     * @Route("/fields", methods={"GET"})
     */
    public function getFields(): Response
    {
        $result = [
            'categories' => [],
            'formats' => [],
            'additional' => [],
            'levels' => [],
            'include' => [],
        ];

        /** @var Category $childCategory */
        foreach ($this->categoryRepository->findChildCategories() as $childCategory) {
            $result['categories'][] = [
                'value' => $childCategory->getId(),
                'title' => $childCategory->getName(),
            ];
        }

        /** @var ProgramFormat $format */
        foreach ($this->programFormatRepository->findActiveFormats() as $format) {
            $result['formats'][] = [
                'id' => $format->getId(),
                'title' => $format->getName(),
            ];
        }

        /** @var ProgramAdditional $additional */
        foreach ($this->programAdditionalRepository->findActiveAdditional() as $additional) {
            $result['additional'][] = [
                'id' => $additional->getId(),
                'title' => $additional->getTitle(),
            ];
        }

        /** @var ProgramLevel $level */
        foreach ($this->programLevelRepository->findActiveLevels() as $level) {
            $result['levels'][] = [
                'id' => $level->getId(),
                'title' => $level->getTitle(),
            ];
        }

        /** @var ProgramInclude $include */
        foreach ($this->programIncludeRepository->findAll() as $include) {
            $result['include'][] = [
                'id' => $include->getId(),
                'title' => $include->getTitle(),
            ];
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/provider-info", methods={"GET"})
     */
    public function currentProviderInfo(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Provider $provider */
        $provider = $user->getProvider();

        return new JsonResponse([
            'currentProvider' => [
                'name' => $provider->getName(),
                'comment' => $provider->getDescription(),
                'image' => $provider->getImage() ? $provider->getImage()->getPublicPath() : null,
                'link' => $provider->getExternalLink(),
            ],
            'isProAccount' => $provider->isProAccount(),
        ]);
    }

    /**
     * @Route("/all-providers")
     */
    public function getAllProviders(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Provider $currentProvider */
        $currentProvider = $user->getProvider();

        $result = [];

        /** @var Provider $provider */
        foreach ($this->providerRepository->findAll() as $provider) {
            if ($provider->getId() === $currentProvider->getId()) {
                continue;
            }

            $result[] = [
                'id' => $provider->getId(),
                'name' => $provider->getName(),
                'comment' => $provider->getDescription(),
                'image' => $provider->getImage() ? $provider->getImage()->getPublicPath() : null,
            ];
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/all-locations")
     */
    public function fetchAll(): Response
    {
        $result = [];

        /** @var Location $city */
        foreach ($this->locationRepository->findCityForList() as $city) {
            $result[] = [
                'id' => $city->getId(),
                'name' => $city->getName(),
                'type' => $city->getType(),
            ];
        }

        /** @var Location $region */
        foreach ($this->locationRepository->findAllRegions() as $region) {
            $subregions = [];

            /** @var Location $childLocation */
            foreach ($region->getChildLocations() as $childLocation) {
                $subregions[] = [
                    'id' => $childLocation->getId(),
                    'name' => $childLocation->getName(),
                ];
            }

            $result[] = [
                'id' => $region->getId(),
                'name' => $region->getName(),
                'type' => $region->getType(),
                'subregions' => $subregions,
            ];
        }

        return new JsonResponse($result);
    }

    /**
     * @Route("/save")
     */
    public function save(Request $request): Response
    {

        $a = 1;
        die;
    }
}
