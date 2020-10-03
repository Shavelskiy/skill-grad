<?php

namespace App\Controller;

use App\Entity\Program\Program;
use App\Entity\Program\ProgramGallery;
use App\Entity\Provider;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use App\Service\SearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/provider")
 */
class ProviderController extends BaseCatalogRepository
{
    protected const PAGE_ITEM_COUNT = 10;

    protected ProviderRepository $providerRepository;
    protected ProgramRepository $programRepository;

    public function __construct(
        ProviderRepository $providerRepository,
        ProgramRepository $programRepository,
        CategoryRepository $categoryRepository,
        SearchService $searchService
    ) {
        $this->providerRepository = $providerRepository;
        $this->programRepository = $programRepository;
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
     * @Route("/{provider}", name="provider.view", methods={"GET"})
     */
    public function view(Provider $provider, Request $request): Response
    {
        $searchResult = $this->getProgramSearchResult($request, 0, [$provider->getId()]);
        $programs = $this->programRepository->findBy(['id' => $searchResult['ids']]);

        $gallery = [];

        /** @var Program $program */
        foreach ($programs as $program) {
            /** @var ProgramGallery $gallery */
            foreach ($program->getGallery() as $gallery) {
                $gallery[] = $gallery;
            }
        }

        return $this->render('provider/view.html.twig', [
            'programs' => $programs,
            'gallery' => $gallery,
            'provider' => $provider,
        ]);
    }
}
