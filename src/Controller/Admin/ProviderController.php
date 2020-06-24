<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Provider;
use App\Entity\ProviderRequisites;
use App\Helpers\SearchHelper;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use App\Repository\ProviderRepository;
use App\Repository\ProviderRequisitesRepository;
use App\Service\LocationService;
use App\Service\UploadServiceInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/provider")
 */
class ProviderController extends AbstractController
{
    protected CategoryRepository $categoryRepository;
    protected ProviderRepository $providerRepository;
    protected ProviderRequisitesRepository $providerRequisitesRepository;
    protected LocationRepository $locationRepository;
    protected UploadServiceInterface $uploadService;
    protected LocationService $locationService;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProviderRepository $providerRepository,
        ProviderRequisitesRepository $providerRequisitesRepository,
        LocationRepository $locationRepository,
        UploadServiceInterface $uploadService,
        LocationService $locationService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->providerRepository = $providerRepository;
        $this->providerRequisitesRepository = $providerRequisitesRepository;
        $this->locationRepository = $locationRepository;
        $this->uploadService = $uploadService;
        $this->locationService = $locationService;
    }

    /**
     * @Route("", name="admin.provider.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [Provider::class]);

        $paginator = $this->providerRepository->getPaginatorResult($searchQuery);

        $items = [];
        foreach ($paginator->getItems() as $item) {
            $items[] = $this->prepareItem($item);
        }

        $data = [
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ];

        return new JsonResponse($data);
    }

    public function prepareItem(Provider $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'image' => $item->getImage() ? $item->getImage()->getPublicPath() : null,
        ];
    }

    /**
     * @Route("/{id}", name="admin.provider.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     */
    public function view(int $id): Response
    {
        try {
            if ($id < 1) {
                throw new RuntimeException('');
            }

            /** @var Provider $provider */
            $provider = $this->providerRepository->find($id);

            if ($provider === null) {
                throw new RuntimeException('');
            }

            $mainCategories = [];

            /** @var Category $mainCategory */
            foreach ($provider->getCategoryGroups() as $mainCategory) {
                $mainCategories[] = [
                    'id' => $mainCategory->getId(),
                    'name' => $mainCategory->getName(),
                    'sort' => $mainCategory->getSort(),
                ];
            }

            $categories = [];

            /** @var Category $category */
            foreach ($provider->getCategories() as $category) {
                $categories[] = [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'sort' => $category->getSort(),
                ];
            }

            $locations = [];

            /** @var Location $location */
            foreach ($provider->getLocations() as $location) {
                $locations[] = [
                    'id' => $location->getId(),
                    'title' => $this->locationService->getLocationPath($location),
                    'sort' => $location->getSort(),
                ];
            }

            $data = [
                'id' => $provider->getId(),
                'name' => $provider->getName(),
                'description' => $provider->getDescription(),
                'image' => $provider->getImage() ? $provider->getImage()->getPublicPath() : null,
                'mainCategories' => $mainCategories,
                'categories' => $categories,
                'locations' => $locations,
            ];

            if ($providerRequisites = $this->providerRequisitesRepository->findProviderRequisitesByProvider($provider)) {
                $data = array_merge($data, [
                    'organizationName' => $providerRequisites->getOrganizationName(),
                    'legalAddress' => $providerRequisites->getLegalAddress(),
                    'mailingAddress' => $providerRequisites->getMailingAddress(),
                    'ITN' => $providerRequisites->getITN(),
                    'IEC' => $providerRequisites->getIEC(),
                    'PSRN' => $providerRequisites->getPSRN(),
                    'OKPO' => $providerRequisites->getOKPO(),
                    'checkingAccount' => $providerRequisites->getCheckingAccount(),
                    'correspondentAccount' => $providerRequisites->getCorrespondentAccount(),
                    'BIC' => $providerRequisites->getBIC(),
                    'bank' => $providerRequisites->getBank(),
                ]);
            }

            return new JsonResponse($data);
        } catch (Exception $e) {
            return new JsonResponse([], 404);
        }
    }

    /**
     * @Route("", name="admin.provider.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $provider = new Provider();
            $this->setProviderFieldsFromRequest($provider, $request);

            /** @var UploadedFile $uploadImage */
            if ($uploadImage = $request->files->get('uploadImage')) {
                $providerImage = $this->uploadService->createUpload($uploadImage);

                $provider->setImage($providerImage);

                $this->getDoctrine()->getManager()->persist($providerImage);
            }

            $providerRequisites = (new ProviderRequisites())->setProvider($provider);
            $this->setProviderRequisitesFieldsFromRequest($providerRequisites, $request);

            $this->getDoctrine()->getManager()->persist($providerRequisites);
            $this->getDoctrine()->getManager()->persist($provider);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse([]);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @Route("", name="admin.provider.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        /** @var Provider $provider */
        $provider = $this->providerRepository->find($request->get('id'));

        if ($provider === null) {
            return new JsonResponse([], 404);
        }

        $this->setProviderFieldsFromRequest($provider, $request);

        $providerRequisites = $this->providerRequisitesRepository->findProviderRequisitesByProvider($provider);

        if ($providerRequisites === null) {
            $providerRequisites = (new ProviderRequisites())->setProvider($provider);
        }

        $this->setProviderRequisitesFieldsFromRequest($providerRequisites, $request);

        try {
            /** @var UploadedFile $uploadImage */
            $uploadImage = $request->files->get('uploadImage');

            if ($uploadImage || $request->get('image') === 'null') {
                $oldImage = $provider->getImage();
                if ($oldImage !== null) {
                    $provider->setImage(null);
                    $this->uploadService->deleteUpload($oldImage);
                }
            }

            if ($uploadImage) {
                $uploadImage = $this->uploadService->createTestUpload($uploadImage);
                $providerImage = $this->uploadService->createUpload($uploadImage);
                $provider->setImage($providerImage);

                $this->getDoctrine()->getManager()->persist($providerImage);
            }

            $this->getDoctrine()->getManager()->persist($provider);
            $this->getDoctrine()->getManager()->persist($providerRequisites);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse();
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }

    protected function setProviderFieldsFromRequest(Provider $provider, Request $request): void
    {
        $provider
            ->setName($request->get('name'))
            ->setDescription($request->get('description'))
            ->setCategoryGroups($this->categoryRepository->findBy(['id' => $request->get('mainCategories')]))
            ->setCategories($this->categoryRepository->findBy(['id' => $request->get('categories')]))
            ->setLocations($this->locationRepository->findBy(['id' => $request->get('locations')]));
    }

    protected function setProviderRequisitesFieldsFromRequest(ProviderRequisites $providerRequisites, Request $request): void
    {
        $providerRequisites
            ->setOrganizationName($request->get('organizationName'))
            ->setLegalAddress($request->get('legalAddress'))
            ->setMailingAddress($request->get('mailingAddress'))
            ->setITN($request->get('ITN'))
            ->setIEC($request->get('IEC'))
            ->setPSRN($request->get('PSRN'))
            ->setOKPO($request->get('OKPO'))
            ->setCheckingAccount($request->get('checkingAccount'))
            ->setCorrespondentAccount($request->get('correspondentAccount'))
            ->setBIC($request->get('BIC'))
            ->setBank($request->get('bank'));
    }

    /**
     * @Route("", name="admin.provider.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        /** @var Provider $provider */
        $provider = $this->providerRepository->find($request->get('id'));

        if ($provider === null) {
            return new JsonResponse([], 404);
        }

        if ($provider->getImage()) {
            $this->uploadService->deleteUpload($provider->getImage());
        }

        if ($providerRequisites = $this->providerRequisitesRepository->findProviderRequisitesByProvider($provider)) {
            $this->getDoctrine()->getManager()->remove($providerRequisites);
        }

        $this->getDoctrine()->getManager()->remove($provider);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }
}
