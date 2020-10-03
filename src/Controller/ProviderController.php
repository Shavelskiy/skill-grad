<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProviderRepository;
use App\Service\SearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/provider")
 */
class ProviderController extends BaseCatalogRepository
{
    protected const PAGE_ITEM_COUNT = 10;

    protected ProviderRepository $providerRepository;

    public function __construct(
        ProviderRepository $providerRepository,
        CategoryRepository $categoryRepository,
        SearchService $searchService
    ) {
        $this->providerRepository = $providerRepository;
        $this->categoryRepository = $categoryRepository;
        $this->searchService = $searchService;
    }

    /**
     * @Route("", name="provider.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $page = $this->getPageFromRequest($request);

        $searchResult = $this->getProviderSearchResult($request, $page);

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
