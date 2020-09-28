<?php

namespace App\Controller;

use App\Repository\ProviderRepository;
use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/provider")
 */
class ProviderController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected ProviderRepository $providerRepository;
    protected SearchService $searchService;

    public function __construct(
        ProviderRepository $providerRepository,
        SearchService $searchService
    ) {
        $this->providerRepository = $providerRepository;
        $this->searchService = $searchService;
    }

    /**
     * @Route("", name="provider.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $page = (int)($request->get('page', 1));

        $searchResult = $this->searchService->findProviders(
            $page,
            $request->get('q', '')
        );

        $providers = $this->providerRepository->findBy(['id' => $searchResult['ids']]);

        $favoriteProviderIds = [];

        if ($this->getUser()) {
            foreach ($this->getUser()->getFavoriteProviders() as $provider) {
                $favoriteProviderIds[] = $provider->getId();
            }
        }

        return $this->render('provider/index.html.twig', [
            'providers' => $providers,
            'page' => $page,
            'total_pages' => $searchResult['total_pages'],
            'favorite_provider_ids' => $favoriteProviderIds,
        ]);
    }

    /**
     * @Route("/{id}", name="provider.view", methods={"GET"})
     */
    public function view(int $id): Response
    {
        $provider = $this->providerRepository->find($id);

        if ($provider === null) {
            throw  new NotFoundHttpException('');
        }

        return $this->render('provider/view.html.twig', [
            'provider' => $provider,
        ]);
    }
}
