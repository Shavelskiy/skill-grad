<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Program\ActionFavoriteProvider;
use App\Entity\Program\Certificate;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramAdditional;
use App\Entity\Program\ProgramFormat;
use App\Entity\Program\ProgramGallery;
use App\Entity\Program\ProgramInclude;
use App\Entity\Program\ProgramLevel;
use App\Entity\Program\Teacher;
use App\Entity\Provider;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use App\Repository\ProgramAdditionalRepository;
use App\Repository\ProgramFormatRepository;
use App\Repository\ProgramIncludeRepository;
use App\Repository\ProgramLevelRepository;
use App\Repository\ProviderRepository;
use App\Service\UploadServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/program-form")
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
    protected UploadServiceInterface $uploadService;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProgramFormatRepository $programFormatRepository,
        ProgramAdditionalRepository $programAdditionalRepository,
        ProgramLevelRepository $programLevelRepository,
        ProgramIncludeRepository $programIncludeRepository,
        ProviderRepository $providerRepository,
        LocationRepository $locationRepository,
        UploadServiceInterface $uploadService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->programFormatRepository = $programFormatRepository;
        $this->programAdditionalRepository = $programAdditionalRepository;
        $this->programLevelRepository = $programLevelRepository;
        $this->programIncludeRepository = $programIncludeRepository;
        $this->providerRepository = $providerRepository;
        $this->locationRepository = $locationRepository;
        $this->uploadService = $uploadService;
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
                'value' => $level->getId(),
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
            foreach ($this->locationRepository->findRegionCities($region) as $childLocation) {
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
        /** @var User $user */
        $user = $this->getUser();

        $program = (new Program())
            ->setAuthor($user)
            ->setActive(true)
            ->setName($request->get('name'))
            ->setCategories($this->categoryRepository->findBy(['id' => $request->get('categories')]))
            ->setAnnotation($request->get('annotation'))
            ->setDetailText($request->get('detailText'))
            ->setTeachers($this->getTeacherFromRequest($request))
            ->setDuration($request->get('duration'))
            ->setFormat($request->get('format'))
            ->setProcessDescription($request->get('processDescription'))
            ->setDesign($request->get('programDesign'))
            ->setKnowledgeCheck($request->get('knowledgeCheck'))
            ->setAdditional($request->get('additional'))
            ->setAdvantages($request->get('advantages'))
            ->setProviders($this->getProvidersFromRequest($request))
            ->setTargetAudience($request->get('targetAudience'))
            ->setLevel($this->programLevelRepository->find($request->get('level')))
            ->setPreparation($request->get('preparations'))
            ->setGainedKnowledge($request->get('gainedKnowledge'))
            ->setCertificate($this->getCertificateFromRequest($request))
            ->setTrainingDate($request->get('traningDate'))
            ->setOccupationMode($request->get('occupationMode'))
            ->setLocation($request->get('location'))
            ->setIncludes($request->get('include'))
            ->setPrice($request->get('price'))
            ->setShowPriceReduction($request->get('showPriceReduction'))
            ->setDiscount($request->get('discounts'))
            ->setProviderActions($request->get('actions'))
            ->setActionFavoriteProvider($this->getFavoriteProviderActionFromRequest($request))
            ->setTermOfPayment($request->get('termOfPayment'))
            ->setGallery($this->getGalleryFromRequest($request))
            ->setLocations($this->locationRepository->findBy(['id' => $request->get('locations')]))
            ->setAdditionalInfo($request->get('additionalInfo'));

        $this->getDoctrine()->getManager()->persist($program);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    protected function getTeacherFromRequest(Request $request): array
    {
        $teachers = [];

        $teacherFiles = $request->files->get('teachers');

        foreach ($request->get('teachers') as $key => $requestTeacherName) {
            $teacher = (new Teacher())
                ->setName($requestTeacherName);

            if (isset($teacherFiles[$key])) {
                $teacherFile = $teacherFiles[$key];

                $teacherImage = $this->uploadService->createUpload($teacherFile);
                $teacher->setPhoto($teacherImage);

                $this->getDoctrine()->getManager()->persist($teacherImage);
            }

            $this->getDoctrine()->getManager()->persist($teacher);

            $teachers[] = $teacher;
        }

        return $teachers;
    }

    protected function getProvidersFromRequest(Request $request): array
    {
        $providers = [];

        if (!empty($request->get('selectedProvidersIds'))) {
            $providers = $this->providerRepository->findBy(['id' => $request->get('selectedProvidersIds')]);
        }

        $providerFiles = $request->files->get('newProviders');

        foreach ($request->get('newProviders') as $key => $newProvider) {
            $provider = (new Provider())
                ->setName($newProvider['name'])
                ->setExternalLink($newProvider['link'])
                ->setDescription($newProvider['comment']);

            if (isset($providerFiles[$key])) {
                $providerFile = $providerFiles[$key];

                $providerImage = $this->uploadService->createUpload($providerFile);
                $provider->setImage($providerImage);

                $this->getDoctrine()->getManager()->persist($providerImage);
            }

            $this->getDoctrine()->getManager()->persist($provider);

            $providers[] = $provider;
        }

        return $providers;
    }

    protected function getCertificateFromRequest(Request $request): ?Certificate
    {
        $certificate = (new Certificate())
            ->setName('certificateName');

        if ($request->files->has('certificateImage')) {
            $certificateFile = $request->files->get('certificateImage');

            $certificateImage = $this->uploadService->createUpload($certificateFile);
            $certificate->setImage($certificateImage);

            $this->getDoctrine()->getManager()->persist($certificateImage);
        }

        $this->getDoctrine()->getManager()->persist($certificate);

        return $certificate;
    }

    protected function getFavoriteProviderActionFromRequest(Request $request): ActionFavoriteProvider
    {
        $favoriteProviderAction = $request->get('favoriteProviderAction');

        $actionFavoriteProvider = (new ActionFavoriteProvider())
            ->setFirstDiscount($favoriteProviderAction['firstDiscount'])
            ->setDiscount($favoriteProviderAction['nextDiscount']);

        $this->getDoctrine()->getManager()->persist($actionFavoriteProvider);

        return $actionFavoriteProvider;
    }

    protected function getGalleryFromRequest(Request $request): array
    {
        $gallery = [];

        $galleryFiles = $request->files->get('gallery');

        foreach ($request->get('gallery') as $key => $name) {
            $galleryFile = $galleryFiles[$key];

            $galleryImage = $this->uploadService->createUpload($galleryFile);

            $item = (new ProgramGallery())
                ->setName($name)
                ->setImage($galleryImage);

            $this->getDoctrine()->getManager()->persist($galleryImage);
            $this->getDoctrine()->getManager()->persist($item);

            $gallery[] = $item;
        }

        return $gallery;
    }
}
