<?php

namespace App\Controller;

use App\Controller\Traits\SeoTrait;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramGallery;
use App\Entity\Provider;
use App\Enum\PagesKeys;
use App\Repository\CategoryRepository;
use App\Repository\Content\Seo\DefaultSeoRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use App\Service\SearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/provider")
 */
class ProviderController extends BaseCatalogController
{
    protected const PAGE_ITEM_COUNT = 10;

    use SeoTrait;

    protected ProviderRepository $providerRepository;
    protected ProgramRepository $programRepository;

    public function __construct(
        ProviderRepository $providerRepository,
        ProgramRepository $programRepository,
        CategoryRepository $categoryRepository,
        DefaultSeoRepository $defaultSeoRepository,
        SearchService $searchService
    ) {
        $this->providerRepository = $providerRepository;
        $this->programRepository = $programRepository;
        $this->categoryRepository = $categoryRepository;
        $this->searchService = $searchService;

        $this->setDefaultSeoRepository($defaultSeoRepository);
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

        return $this->render('provider/index.html.twig', $this->applySeoToDefaultPage([
            'providers' => $providers,
            'page' => $page,
            'total_pages' => $searchResult['total_pages'],
            'favorite_provider_ids' => $favoriteProviderIds,
        ], PagesKeys::PROVIDER_INDEX_PAGE_SLUG));
    }

    /**
     * @Route("/{provider}", name="provider.view", methods={"GET"})
     */
    public function view(Provider $provider, Request $request): Response
    {
        $searchResult = $this->getProgramSearchResult($request, 0, [$provider->getId()]);
        $programs = $this->programRepository->findBy(['id' => $searchResult['ids']]);

        $gallery = [];

        foreach ($programs as $program) {
            /** @var ProgramGallery $programGallery */
            foreach ($program->getGallery() as $programGallery) {
                $gallery[] = $programGallery;
            }
        }

        return $this->render('provider/view.html.twig', $this->applySeoToProvider([
            'programs' => $programs,
            'gallery' => $gallery,
            'provider' => $provider,
        ], $provider));
    }
}
