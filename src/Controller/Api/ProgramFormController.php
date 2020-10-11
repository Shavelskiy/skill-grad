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
use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use App\Service\UploadServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
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
    protected ProgramRepository $programRepository;
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
        ProgramRepository $programRepository,
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
        $this->programRepository = $programRepository;
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
     * @Route("/{program}", name="api.porgram-from.fetch", methods={"GET"})
     */
    public function fetchProgram(Program $program): Response
    {
        if ($program->getAuthor()->getUsername() !== $this->getUser()->getUsername()) {
            return new JsonResponse([], 403);
        }

        $categories = [null, null, null];

        /** @var Category $category */
        foreach ($program->getCategories() as $key => $category) {
            $categories[$key] = $category->getId();
        }

        $legalEntityPayment = $program->getPayment(ProgramPayment::LEGAL_ENTITY_TYPE);
        $individualPayment = $program->getPayment(ProgramPayment::INDIVIDUAL_TYPE);

        $data = [
            'id' => $program->getId(),
            'name' => $program->getName(),
            'categories' => $categories,
            'annotation' => $program->getAnnotation(),
            'detailText' => $program->getDetailText(),
            'teachers' => $program->getTeachers()->map(fn(Teacher $teacher) => [
                'id' => $teacher->getId(),
                'name' => $teacher->getName(),
                'image' => $teacher->getPhoto() ? $teacher->getPhoto()->getPublicPath() : null,
            ])->toArray(),
            'duration' => [
                'type' => $program->getDurationType(),
                'value' => $program->getDurationValue(),
            ],
            'format' => [
                'id' => $program->getProgramFormat() ? $program->getProgramFormat()->getId() : null,
                'otherValue' => $program->getFormatOther(),
            ],
            'processDescription' => $program->getProcessDescription(),
            'programDesign' => [
                'type' => $program->getDesignType(),
                'value' => $program->getDesignValue(),
            ],
            'knowledgeCheck' => [
                'id' => $program->isKnowledgeCheck(),
                'otherValue' => $program->getKnowledgeCheckOther(),
            ],
            'additional' => [
                'values' => $program->getProgramAdditional()->map(fn(ProgramAdditional $programAdditional) => $programAdditional->getId())->toArray(),
                'otherValue' => $program->getOtherAdditional(),
            ],
            'advantages' => $program->getAdvantages(),
            'newProviders' => [],
            'selectedProvidersIds' => [],
            'targetAudience' => $program->getTargetAudience(),
            'level' => $program->getLevel()->getId(),
            'preparations' => $program->getPreparation(),
            'gainedKnowledge' => $program->getGainedKnowledge(),
            'certificate' => [
                'name' => $program->getCertificate() !== null ? $program->getCertificate()->getName() : '',
                'file' => $program->getCertificate() !== null && $program->getCertificate()->getImage() !== null ? $program->getCertificate()->getImage()->getPublicPath() : null,
            ],
            'trainingDate' => [
                'type' => $program->getTrainingDateType(),
                'extra' => $program->getTrainingDateExtra(),
            ],
            'occupationMode' => [
                'type' => $program->getProgramOccupationMode() ? $program->getProgramOccupationMode()->getType() : null,
                'extra' => $program->getProgramOccupationMode() ? $program->getProgramOccupationMode()->getExtra() : null,
            ],
            'location' => $program->getLocation(),
            'include' => [
                'values' => $program->getProgramIncludes()->map(fn(ProgramInclude $programInclude) => $programInclude->getId())->toArray(),
                'otherValue' => $program->getOtherInclude()
            ],
            'price' => [
                'legalEntity' => [
                    'checked' => $legalEntityPayment !== null && $legalEntityPayment->getPrice() !== null,
                    'price' => $legalEntityPayment !== null && $legalEntityPayment->getPrice() !== null ? $legalEntityPayment->getPrice() : 0,
                ],
                'individual' => [
                    'checked' => $individualPayment !== null && $individualPayment->getPrice() !== null,
                    'price' => $individualPayment !== null && $individualPayment->getPrice() !== null ? $individualPayment->getPrice() : 0,
                ],
                'byRequest' => ($legalEntityPayment === null || $individualPayment === null) || ($legalEntityPayment->getPrice() === null && $individualPayment->getPrice() === null),
            ],
            'showPriceReduction' => $program->isShowPriceReduction(),
            'discounts' => [
                'legalEntity' => [
                    'checked' => $legalEntityPayment !== null && $legalEntityPayment->getDiscount() !== null,
                    'value' => $legalEntityPayment !== null && $legalEntityPayment->getDiscount() !== null ? $legalEntityPayment->getDiscount() : 0,
                ],
                'individual' => [
                    'checked' => $individualPayment !== null && $individualPayment->getDiscount() !== null,
                    'value' => $individualPayment !== null && $individualPayment->getDiscount() !== null ? $individualPayment->getDiscount() : 0,
                ],
                'byRequest' => ($legalEntityPayment === null || $individualPayment === null) || ($legalEntityPayment->getDiscount() === null && $individualPayment->getDiscount() === null),
            ],
            'actions' => $program->getProviderActions(),
            'favoriteProviderAction' => [
                'firstDiscount' => $program->getActionFavoriteProvider()->getFirstDiscount(),
                'nextDiscount' => $program->getActionFavoriteProvider()->getDiscount(),
            ],
            'termOfPayment' => [
                'legalEntity' => [
                    'checked' => $legalEntityPayment !== null && $legalEntityPayment->getTermOfPayment() !== null,
                    'value' => $legalEntityPayment !== null && $legalEntityPayment->getTermOfPayment() !== null ? $legalEntityPayment->getTermOfPayment() : '',
                ],
                'individual' => [
                    'checked' => $individualPayment !== null && $individualPayment->getTermOfPayment() !== null,
                    'value' => $individualPayment !== null && $individualPayment->getTermOfPayment() !== null ? $individualPayment->getTermOfPayment() : '',
                ],
                'byRequest' => ($legalEntityPayment === null || $individualPayment === null) || ($legalEntityPayment->getTermOfPayment() === null && $individualPayment->getTermOfPayment() === null),
            ],
            'gallery' => $program->getGallery()->map(fn(ProgramGallery $programGallery) => [
                'id' => $programGallery->getId(),
                'name' => $programGallery->getName(),
                'image' => $programGallery->getImage() ? $programGallery->getImage()->getPublicPath() : null,
            ])->toArray(),
            'locations' => $program->getLocations()->map(fn(Location $location) => $location->getId())->toArray(),
            'additionalInfo' => $program->getAdditionalInfo(),
        ];

        return new JsonResponse([
            'program' => $data,
        ]);
    }

    /**
     * @Route("/save", name="api.porgram-from.save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (($id = (int)$request->get('id')) > 0) {
            $program = $this->programRepository->find($id);

            if ($program === null || $program->getAuthor()->getUsername() !== $user->getUsername()) {
                return new JsonResponse([], 403);
            }
        } else {
            $program = (new Program())
                ->setAuthor($user);
        }

        $program
            ->setActive($request->get('active'))
            ->setName($request->get('name'))
            ->setCategories($this->categoryRepository->findBy(['id' => $request->get('categories')]))
            ->setAnnotation($request->get('annotation'))
            ->setDetailText($request->get('detailText'))
            ->setTeachers($this->getTeacherFromRequest($request, $program))
            ->setProcessDescription($request->get('processDescription'))
            ->setAdvantages($request->get('advantages'))
            ->setProviders($this->getProvidersFromRequest($request))
            ->setTargetAudience($request->get('targetAudience'))
            ->setLevel($this->programLevelRepository->find($request->get('level')))
            ->setPreparation($request->get('preparations'))
            ->setGainedKnowledge($request->get('gainedKnowledge'))
            ->setLocation($request->get('location'))
            ->setShowPriceReduction($request->get('showPriceReduction'))
            ->setProviderActions($request->get('actions'))
            ->setGallery($this->getGalleryFromRequest($request))
            ->setLocations($this->locationRepository->findBy(['id' => $request->get('locations')]))
            ->setAdditionalInfo($request->get('additionalInfo'));

        $this->setProgramDuration($request->get('duration'), $program);
        $this->setProgramFormat($request->get('format'), $program);
        $this->setProgramDesign($request->get('programDesign'), $program);
        $this->setProgramKnowledgeCheck($request->get('knowledgeCheck'), $program);
        $this->setProgramAdditional($request->get('additional'), $program);
        $this->setCertificate($request, $program);
        $this->setProgramTrainingDate($request->get('trainingDate'), $program);
        $this->setOccupationMode($request->get('occupationMode'), $program);
        $this->setProgramIncludes($request->get('include'), $program);
        $this->setProgramPrice($request->get('price'), $program);
        $this->setProgramDiscounts($request->get('discounts'), $program);
        $this->setTermOfPayment($request->get('termOfPayment'), $program);
        $this->getFavoriteProviderActionFromRequest($request->get('favoriteProviderAction'), $program);

        $this->entityManager->persist($program);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    protected function getTeacherFromRequest(Request $request, Program $program): array
    {
        $teachers = [];

        $teacherFiles = $request->files->get('teachers');

        /** @var Teacher $teacher */
        foreach ($program->getTeachers() as $teacher) {
            foreach ($request->get('teachers') as $requestTeacherData) {
                if ($requestTeacherData['id'] === $teacher->getId()) {
                    continue 2;
                }
            }

            if ($teacher->getPhoto()) {
                $this->uploadService->deleteUpload($teacher->getPhoto());
            }

            $this->entityManager->remove($teacher);
        }

        foreach ($request->get('teachers') as $key => $requestTeacherData) {
            $teacher = null;

            if (isset($requestTeacherData['id'])) {
                /** @var Teacher $programTeacher */
                foreach ($program->getTeachers() as $programTeacher) {
                    if ($programTeacher->getId() === $requestTeacherData['id']) {
                        $teacher = $programTeacher;
                    }
                }
            }

            if ($teacher === null) {
                $teacher = (new Teacher())
                    ->setProgram($program);
            }

            $teacher->setName($requestTeacherData['name']);

            if ($requestTeacherData['hasImage']) {
                if (isset($teacherFiles[$key])) {
                    if ($teacher->getPhoto()) {
                        $this->uploadService->deleteUpload($teacher->getPhoto());
                        $teacher->setPhoto(null);
                    }

                    $teacherFile = $teacherFiles[$key];

                    $teacherImage = $this->uploadService->createUpload($teacherFile);

                    $teacher->setPhoto($teacherImage);

                    $this->entityManager->persist($teacherImage);
                }
            } elseif ($teacher->getPhoto() !== null) {
                $this->uploadService->deleteUpload($teacher->getPhoto());
                $teacher->setPhoto(null);
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
            $program->setProgramFormat(null);
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
        $program->setProgramAdditional(new ArrayCollection());

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
        $program->setProgramIncludes(new ArrayCollection());

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

    protected function setCertificate(Request $request, Program $program): ?Certificate
    {
        if ($program->getCertificate() !== null) {
            $certificate = $program->getCertificate();
        } else {
            $certificate = new Certificate();
            $program->setCertificate($certificate);
        }

        $data = $request->get('certificate');
        $certificate->setName($data['name']);

        if ($data['hasImage']) {
            if ($request->files->has('certificateImage')) {
                if ($certificate->getImage()) {
                    $this->uploadService->deleteUpload($certificate->getImage());
                    $certificate->setImage(null);
                }

                $certificateFile = $request->files->get('certificateImage');

                $certificateImage = $this->uploadService->createUpload($certificateFile);
                $certificate->setImage($certificateImage);

                $this->entityManager->persist($certificateImage);
            }
        } elseif ($certificate->getImage() !== null) {
            $this->uploadService->deleteUpload($certificate->getImage());
            $certificate->setImage(null);
        }

        $this->entityManager->persist($certificate);

        return $certificate;
    }

    protected function getFavoriteProviderActionFromRequest(array $favoriteProviderAction, Program $program): ActionFavoriteProvider
    {
        if ($program->getActionFavoriteProvider() !== null) {
            $actionFavoriteProvider = $program->getActionFavoriteProvider();
        } else {
            $actionFavoriteProvider = new ActionFavoriteProvider();
        }

        $actionFavoriteProvider
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
