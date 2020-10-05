<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Provider;
use App\Entity\ProviderRequisites;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use App\Service\UploadServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/profile/settings-provider")
 */
class ProviderSettingsController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected CategoryRepository $categoryRepository;
    protected LocationRepository $locationRepository;
    protected UploadServiceInterface $uploadService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository,
        UploadServiceInterface $uploadService
    ) {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
        $this->locationRepository = $locationRepository;
        $this->uploadService = $uploadService;
    }

    /**
     * @Route("", name="api.provider-settins.index", methods={"GET"})
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $data = [
            'image' => null,
            'name' => '',
            'description' => '',
            'pro_account' => true,
            'categories' => [null, null, null],
            'sub_categories' => [],
            'locations' => [
                Location::TYPE_COUNTRY => null,
                Location::TYPE_REGION => null,
                Location::TYPE_CITY => null,
            ],
            'requisites' => [
                'organizationName' => '',
                'legalAddress' => '',
                'mailingAddress' => '',
                'ITN' => '',
                'IEC' => '',
                'PSRN' => '',
                'OKPO' => '',
                'checkingAccount' => '',
                'correspondentAccount' => '',
                'BIC' => '',
                'bank' => '',
            ],
        ];

        if (($provider = $user->getProvider()) !== null) {
            $data['image'] = $provider->getImage() ? $provider->getImage()->getPublicPath() : null;
            $data['name'] = $provider->getName();
            $data['description'] = $provider->getDescription();

            $categories = [];
            $subcategories = [];

            /** @var Category $category */
            foreach ($provider->getCategories() as $category) {
                if ($category->getParentCategory() === null) {
                    if (!in_array($category->getId(), $categories, true)) {
                        $categories[] = $category->getId();
                    }
                } else {
                    $subcategories[] = $category->getId();

                    if (!in_array($category->getParentCategory()->getId(), $categories, true)) {
                        $categories[] = $category->getParentCategory()->getId();
                    }
                }
            }

            $categoriesCount = count($categories);
            for ($i = 0; $i < 3 - $categoriesCount; ++$i) {
                $categories[] = null;
            }

            $data['categories'] = $categories;
            $data['sub_categories'] = $subcategories;

            if (($location = $provider->getLocation()) !== null) {
                $data['locations'][$location->getType()] = $location->getId();

                switch ($location->getType()) {
                    case Location::TYPE_REGION:
                        $data['locations'][Location::TYPE_COUNTRY] = $location->getParentLocation()->getId();
                        break;

                    case Location::TYPE_CITY:
                        $region = $location->getParentLocation();
                        $data['locations'][Location::TYPE_REGION] = $region->getId();
                        $data['locations'][Location::TYPE_COUNTRY] = $region->getParentLocation()->getId();
                        break;
                }
            }

            if (($requisites = $provider->getProviderRequisites()) !== null) {
                $data['requisites'] = [
                    'organizationName' => $requisites->getOrganizationName(),
                    'legalAddress' => $requisites->getLegalAddress(),
                    'mailingAddress' => $requisites->getMailingAddress(),
                    'ITN' => $requisites->getITN(),
                    'IEC' => $requisites->getIEC(),
                    'PSRN' => $requisites->getPSRN(),
                    'OKPO' => $requisites->getOKPO(),
                    'checkingAccount' => $requisites->getCheckingAccount(),
                    'correspondentAccount' => $requisites->getCorrespondentAccount(),
                    'BIC' => $requisites->getBIC(),
                    'bank' => $requisites->getBank(),
                ];
            }
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("", name="api.provider-settins.save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (($provider = $user->getProvider()) === null) {
            $provider = (new Provider())
                ->setUser($user);

            $user->setProvider($provider);
        }

        if (($requisites = $provider->getProviderRequisites()) === null) {
            $requisites = (new ProviderRequisites())
                ->setProvider($provider);

            $provider->setProviderRequisites($requisites);
        }

        $provider
            ->setName($request->get('name'))
            ->setDescription($request->get('description'))
            ->setCategories($this->getSelectedSubcategories($request->get('categories'), $request->get('sub_categories')))
            ->setLocation($this->getSelectedLocation($request->get('locations')));

        $oldImage = $request->get('old_image');
        $image = $request->files->get('image');

        if ($oldImage === null && $provider->getImage() !== null) {
            $this->uploadService->deleteUpload($provider->getImage());
            $provider->setImage(null);
        }

        if ($image !== null) {
            $upload = $this->uploadService->createUpload($image);
            $this->entityManager->persist($upload);
            $provider->setImage($upload);
        }

        $this->fillProviderRequisites($requisites, $request->get('requisites'));

        $this->entityManager->persist($user);
        $this->entityManager->persist($provider);
        $this->entityManager->persist($requisites);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    protected function getSelectedLocation(array $locations): Location
    {
        if ($locations[Location::TYPE_CITY] !== null) {
            return $this->locationRepository->find($locations[Location::TYPE_CITY]);
        }

        if ($locations[Location::TYPE_REGION] !== null) {
            return $this->locationRepository->find($locations[Location::TYPE_REGION]);
        }

        return $this->locationRepository->find($locations[Location::TYPE_COUNTRY]);
    }

    protected function getSelectedSubcategories(array $selectedCategoryIds, array $selectedSubcategoryIds): array
    {
        $result = [];

        $categories = $this->categoryRepository->findBy(['id' => $selectedCategoryIds]);

        foreach ($this->categoryRepository->findBy(['id' => $selectedSubcategoryIds]) as $subcategory) {
            if ($subcategory->getParentCategory() === null) {
                continue;
            }

            foreach ($categories as $category) {
                if ($category->getId() === $subcategory->getParentCategory()->getId()) {
                    $result[] = $subcategory;
                }
            }
        }

        return $result;
    }

    protected function fillProviderRequisites(ProviderRequisites $requisites, array $requestRequisites): void
    {
        $requisites
            ->setOrganizationName($requestRequisites['organizationName'])
            ->setLegalAddress($requestRequisites['legalAddress'])
            ->setMailingAddress($requestRequisites['mailingAddress'])
            ->setITN($requestRequisites['ITN'])
            ->setIEC($requestRequisites['IEC'])
            ->setPSRN($requestRequisites['PSRN'])
            ->setOKPO($requestRequisites['OKPO'])
            ->setCheckingAccount($requestRequisites['checkingAccount'])
            ->setCorrespondentAccount($requestRequisites['correspondentAccount'])
            ->setBIC($requestRequisites['BIC'])
            ->setBank($requestRequisites['bank']);
    }
}
