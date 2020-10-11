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
use App\Entity\Program\ProgramOccupationMode;
use App\Entity\Program\ProgramPayment;
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
use Doctrine\ORM\EntityManagerInterface;
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
    protected EntityManagerInterface $entityManager;
    protected CategoryRepository $categoryRepository;
    protected ProgramFormatRepository $programFormatRepository;
    protected ProgramAdditionalRepository $programAdditionalRepository;
    protected ProgramLevelRepository $programLevelRepository;
    protected ProgramIncludeRepository $programIncludeRepository;
    protected ProviderRepository $providerRepository;
    protected LocationRepository $locationRepository;
    protected UploadServiceInterface $uploadService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository,
        ProgramFormatRepository $programFormatRepository,
        ProgramAdditionalRepository $programAdditionalRepository,
        ProgramLevelRepository $programLevelRepository,
        ProgramIncludeRepository $programIncludeRepository,
        ProviderRepository $providerRepository,
        LocationRepository $locationRepository,
        UploadServiceInterface $uploadService
    ) {
        $this->entityManager = $entityManager;
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
            ->setActive($request->get('active'))
            ->setName($request->get('name'))
            ->setCategories($this->categoryRepository->findBy(['id' => $request->get('categories')]))
            ->setAnnotation($request->get('annotation'))
            ->setDetailText($request->get('detailText'))
            ->setTeachers($this->getTeacherFromRequest($request))
            ->setProcessDescription($request->get('processDescription'))
            ->setAdvantages($request->get('advantages'))
            ->setProviders($this->getProvidersFromRequest($request))
            ->setTargetAudience($request->get('targetAudience'))
            ->setLevel($this->programLevelRepository->find($request->get('level')))
            ->setPreparation($request->get('preparations'))
            ->setGainedKnowledge($request->get('gainedKnowledge'))
            ->setCertificate($this->getCertificateFromRequest($request))
            ->setLocation($request->get('location'))
            ->setShowPriceReduction($request->get('showPriceReduction'))
            ->setProviderActions($request->get('actions'))
            ->setActionFavoriteProvider($this->getFavoriteProviderActionFromRequest($request))
            ->setGallery($this->getGalleryFromRequest($request))
            ->setLocations($this->locationRepository->findBy(['id' => $request->get('locations')]))
            ->setAdditionalInfo($request->get('additionalInfo'));

        $this->setProgramDuration($request->get('duration'), $program);
        $this->setProgramFormat($request->get('format'), $program);
        $this->setProgramDesign($request->get('programDesign'), $program);
        $this->setProgramKnowledgeCheck($request->get('knowledgeCheck'), $program);
        $this->setProgramAdditional($request->get('additional'), $program);
        $this->setProgramTrainingDate($request->get('trainingDate'), $program);
        $this->setOccupationMode($request->get('occupationMode'), $program);
        $this->setProgramIncludes($request->get('include'), $program);
        $this->setProgramPrice($request->get('price'), $program);
        $this->setProgramDiscounts($request->get('discounts'), $program);
        $this->setTermOfPayment($request->get('termOfPayment'), $program);

        $this->entityManager->persist($program);
        $this->entityManager->flush();

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

                $this->entityManager->persist($teacherImage);
            }

            $this->entityManager->persist($teacher);

            $teachers[] = $teacher;
        }

        return $teachers;
    }

    protected function setProgramDuration(array $data, Program $program): void
    {
        $program->setDurationType($data['type']);
        $program->setDurationValue($data['value']);
    }

    protected function setProgramFormat(array $data, Program $program): void
    {
        if ($data['id'] === null) {
            $program->setFormatOther($data['otherValue']);
            return;
        }

        $program->setProgramFormat($this->programFormatRepository->find($data['id']));
        $program->setFormatOther('');
    }

    protected function setProgramDesign(array $data, Program $program): void
    {
        $program->setDesignType($data['type']);

        if ($program->getDesignType() === Program::DESIGN_WORK) {
            $program->setDesignValue([]);
            return;
        }

        if ($program->getDesignType() === Program::DESIGN_SIMPLE) {
            $program->setDesignValue($data['value']);
            return;
        }

        if ($program->getDesignType() === Program::OTHER) {
            $program->setDesignValue([$data['value']]);
            return;
        }
    }

    protected function setProgramKnowledgeCheck(array $data, Program $program): void
    {
        if ($data['id'] === null) {
            $program->setKnowledgeCheck(null);
            $program->setKnowledgeCheckOther($data['otherValue']);
            return;
        }

        $program->setKnowledgeCheck($data['id']);
        $program->setKnowledgeCheckOther('');
    }

    protected function setProgramAdditional(array $data, Program $program): void
    {
        foreach ($data['values'] as $additionalId) {
            if ($additionalId === 0) {
                continue;
            }

            $program->addProgramAdditional(
                $this->programAdditionalRepository->find($additionalId)
            );
        }

        $program->setOtherAdditional($data['otherValue']);
    }

    protected function setProgramTrainingDate(array $data, Program $program): void
    {
        $program->setTrainingDateType($data['type']);

        if ($program->getTrainingDateType() !== Program::TRAINING_DATE_CALENDAR) {
            $program->setTrainingDateExtra(null);
            return;
        }


        $program->setTrainingDateExtra($data['extra']);
    }

    protected function setOccupationMode(array $data, Program $program): void
    {
        $occupationMode = $program->getProgramOccupationMode();

        if ($occupationMode === null) {
            $occupationMode = new ProgramOccupationMode();
        }

        $occupationMode
            ->setProgram($program)
            ->setType($data['type']);

        if (in_array($occupationMode->getType(), [ProgramOccupationMode::OCCUPATION_MODE_ANYTIME, ProgramOccupationMode::OTHER], true)) {
            $occupationMode
                ->setDays(null)
                ->setFromTime(null)
                ->setToTime(null);
        }

        if (in_array($occupationMode->getType(), [ProgramOccupationMode::OCCUPATION_MODE_ANYTIME, ProgramOccupationMode::OCCUPATION_MODE_TIME], true)) {
            $occupationMode->setOtherValue(null);
        }

        if ($occupationMode->getType() === ProgramOccupationMode::OTHER) {
            $occupationMode->setOtherValue($data['extra']['text']);
        }

        if ($occupationMode->getType() === ProgramOccupationMode::OCCUPATION_MODE_TIME) {
            $occupationMode
                ->setDays($data['extra']['selectedDays'])
                ->setFromTime($data['extra']['selectedTime']['start'])
                ->setToTime($data['extra']['selectedTime']['end']);
        }

        $this->entityManager->persist($occupationMode);

        $program->setProgramOccupationMode($occupationMode);
    }

    protected function setProgramIncludes(array $data, Program $program): void
    {
        foreach ($data['values'] as $includeId) {
            if ($includeId === 0) {
                continue;
            }

            $program->addProgramInclude(
                $this->programIncludeRepository->find($includeId)
            );
        }

        $program->setOtherInclude($data['otherValue']);
    }

    protected function setProgramPrice(array $data, Program $program): void
    {
        $this->setPersonProgramPrice($data, $program, ProgramPayment::LEGAL_ENTITY_TYPE);
        $this->setPersonProgramPrice($data, $program, ProgramPayment::INDIVIDUAL_TYPE);
    }

    protected function setPersonProgramPrice(array $data, Program $program, string $type): void
    {
        $paymentItem = $this->getProgramPaymentItem($program, $type);

        $priceData = $data[$type];
        $paymentItem->setPrice($priceData['checked'] && !$data['byRequest'] ? $priceData['price'] : null);

        $this->entityManager->persist($paymentItem);
    }

    protected function setProgramDiscounts(array $data, Program $program): void
    {
        $this->setPersonProgramDiscount($data, $program, ProgramPayment::LEGAL_ENTITY_TYPE);
        $this->setPersonProgramDiscount($data, $program, ProgramPayment::INDIVIDUAL_TYPE);
    }

    protected function setPersonProgramDiscount(array $data, Program $program, string $type): void
    {
        $paymentItem = $this->getProgramPaymentItem($program, $type);

        $discountData = $data[$type];
        $paymentItem->setDiscount($discountData['checked'] && !$data['byRequest'] ? $discountData['value'] : null);

        $this->entityManager->persist($paymentItem);
    }

    protected function setTermOfPayment(array $data, Program $program): void
    {
        $this->setPersonTermOfPayment($data, $program, ProgramPayment::LEGAL_ENTITY_TYPE);
        $this->setPersonTermOfPayment($data, $program, ProgramPayment::INDIVIDUAL_TYPE);
    }

    protected function setPersonTermOfPayment(array $data, Program $program, string $type): void
    {
        $paymentItem = $this->getProgramPaymentItem($program, $type);

        $termsData = $data[$type];
        $paymentItem->setTermOfPayment($termsData['checked'] && !$data['byRequest'] ? $termsData['value'] : null);

        $this->entityManager->persist($paymentItem);
    }

    protected function getProgramPaymentItem(Program $program, string $type): ProgramPayment
    {
        $paymentItem = $program->getPayment($type);

        if ($paymentItem === null) {
            $paymentItem = (new ProgramPayment())
                ->setType($type)
                ->setProgram($program);

            $program->addPayment($paymentItem);
        }

        return $paymentItem;
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

                $this->entityManager->persist($providerImage);
            }

            $this->entityManager->persist($provider);

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

            $this->entityManager->persist($certificateImage);
        }

        $this->entityManager->persist($certificate);

        return $certificate;
    }

    protected function getFavoriteProviderActionFromRequest(Request $request): ActionFavoriteProvider
    {
        $favoriteProviderAction = $request->get('favoriteProviderAction');

        $actionFavoriteProvider = (new ActionFavoriteProvider())
            ->setFirstDiscount($favoriteProviderAction['firstDiscount'])
            ->setDiscount($favoriteProviderAction['nextDiscount']);

        $this->entityManager->persist($actionFavoriteProvider);

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

            $this->entityManager->persist($galleryImage);
            $this->entityManager->persist($item);

            $gallery[] = $item;
        }

        return $gallery;
    }
}
