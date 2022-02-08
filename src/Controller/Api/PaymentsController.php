<?php

namespace App\Controller\Api;

use App\Dto\SearchQuery;
use App\Entity\Service\AbstractService;
use App\Entity\Service\Document;
use App\Entity\User;
use App\Repository\ServiceRepository;
use App\Service\DocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/payments")
 */
class PaymentsController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected ServiceRepository $serviceRepository;
    protected DocumentService $documentService;

    public function __construct(
        ServiceRepository $serviceRepository,
        DocumentService $documentService
    ) {
        $this->serviceRepository = $serviceRepository;
        $this->documentService = $documentService;
    }

    /**
     * @Route("", name="api.payments.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $query = (new SearchQuery())
            ->setSearch([
                'user' => $this->getUser(),
            ])
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->serviceRepository->getPaginatorResult($query);

        $services = [];

        /** @var AbstractService $service */
        foreach ($searchResult->getItems() as $service) {
            $documents = [];

            /** @var Document $document */
            foreach ($service->getDocuments() as $document) {
                $documents[] = [
                    'id' => $document->getId(),
                    'path' => $this->documentService->generateDownloadPath($document),
                    'name' => $document->getName(),
                ];
            }

            $services[] = [
                'id' => $service->getId(),
                'date' => $service->getCreatedAt()->format('c'),
                'name' => $service->getTitle(),
                'price' => $service->getPrice(),
                'number' => $service->getNumber(),
                'documents' => $documents,
            ];
        }

        return new JsonResponse([
            'items' => $services,
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
        ]);
    }

    /**
     * @Route("/balance", name="api.payments.balance", methods={"GET"})
     */
    public function balance(): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            return new JsonResponse([], 403);
        }

        if (($provider = $user->getProvider()) === null) {
            return new JsonResponse([], 403);
        }

        return new JsonResponse([
            'balance' => $provider->getBalance(),
        ]);
    }
}
