<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Provider;
use App\Entity\ProviderRequisites;
use App\Helpers\SearchHelper;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use App\Repository\ProviderRepository;
use App\Repository\ProviderRequisitesRepository;
use App\Service\UploadServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
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
    protected EntityManagerInterface $entityManager;
    protected CategoryRepository $categoryRepository;
    protected ProviderRepository $providerRepository;
    protected ProviderRequisitesRepository $providerRequisitesRepository;
    protected LocationRepository $locationRepository;
    protected UploadServiceInterface $uploadService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository,
        ProviderRepository $providerRepository,
        ProviderRequisitesRepository $providerRequisitesRepository,
        LocationRepository $locationRepository,
        UploadServiceInterface $uploadService
    ) {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
        $this->providerRepository = $providerRepository;
        $this->providerRequisitesRepository = $providerRequisitesRepository;
        $this->locationRepository = $locationRepository;
        $this->uploadService = $uploadService;
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

        return new JsonResponse([
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ]);
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
     * @Route("/{provider}", name="admin.provider.view", methods={"GET"}, requirements={"provider"="[0-9]+"})
     */
    public function view(Provider $provider): Response
    {
        try {
            $categories = [];

            /** @var Category $category */
            foreach ($provider->getCategories() as $category) {
                $categories[] = [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                    'sort' => $category->getSort(),
                ];
            }

            $data = [
                'id' => $provider->getId(),
                'name' => $provider->getName(),
                'description' => $provider->getDescription(),
                'image' => $provider->getImage() ? $provider->getImage()->getPublicPath() : null,
                'categories' => $categories,
                'location' => $provider->getLocation() ? $provider->getLocation()->getId() : null,
                'balance' => $provider->getBalance(),
            ];

            if ($providerRequisites = $this->providerRequisitesRepository->findProviderRequisitesByProvider($provider)) {
                $data = array_merge($data, [
                    'organizationName' => $providerRequisites->getOrganizationName() ?: '',
                    'legalAddress' => $providerRequisites->getLegalAddress() ?: '',
                    'mailingAddress' => $providerRequisites->getMailingAddress() ?: '',
                    'ITN' => $providerRequisites->getITN() ?: '',
                    'IEC' => $providerRequisites->getIEC() ?: '',
                    'PSRN' => $providerRequisites->getPSRN() ?: '',
                    'OKPO' => $providerRequisites->getOKPO() ?: '',
                    'checkingAccount' => $providerRequisites->getCheckingAccount() ?: '',
                    'correspondentAccount' => $providerRequisites->getCorrespondentAccount() ?: '',
                    'BIC' => $providerRequisites->getBIC() ?: '',
                    'bank' => $providerRequisites->getBank() ?: '',
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

                $this->entityManager->persist($providerImage);
            }

            $providerRequisites = (new ProviderRequisites())->setProvider($provider);
            $this->setProviderRequisitesFieldsFromRequest($providerRequisites, $request);

            $this->entityManager->persist($providerRequisites);
            $this->entityManager->persist($provider);
            $this->entityManager->flush();

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

                $this->entityManager->persist($providerImage);
            }

            $this->entityManager->persist($provider);
            $this->entityManager->persist($providerRequisites);
            $this->entityManager->flush();

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
            ->setBalance($request->get('balance'))
            ->setCategories($this->categoryRepository->findBy(['id' => $request->get('categories')]))
            ->setLocation($this->locationRepository->findOneBy(['id' => $request->get('location')]));
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
            $this->entityManager->remove($providerRequisites);
        }

        $this->entityManager->remove($provider);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
