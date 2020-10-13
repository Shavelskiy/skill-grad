<?php

namespace App\Controller;

use App\Controller\Traits\SeoTrait;
use App\Enum\PagesKeys;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\Content\Seo\DefaultSeoRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use App\Service\SearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/search")
 */
class SearchController extends BaseCatalogController
{
    use SeoTrait;

    protected ProgramRepository $programRepository;
    protected ProviderRepository $providerRepository;
    protected ArticleRepository $articleRepository;

    public function __construct(
        SearchService $searchService,
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository,
        ProviderRepository $providerRepository,
        ArticleRepository $articleRepository,
        DefaultSeoRepository $defaultSeoRepository
    ) {
        $this->searchService = $searchService;
        $this->categoryRepository = $categoryRepository;
        $this->programRepository = $programRepository;
        $this->providerRepository = $providerRepository;
        $this->articleRepository = $articleRepository;

        $this->setDefaultSeoRepository($defaultSeoRepository);
    }

    /**
     * @Route("", name="app.search", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $programPage = $this->getPageFromRequest($request, 'program_page');
        $providerPage = $this->getPageFromRequest($request, 'provider_page');
        $blogPage = $this->getPageFromRequest($request, 'blog_page');

        $programSearchResult = $this->getProgramSearchResult($request, $programPage);
        $providerSearchResult = $this->getProviderSearchResult($request, $providerPage);
        $articleSearchResult = $this->getArticleSearchResult($request, $blogPage);

        return $this->render('search/index.html.twig', $this->applySeoToDefaultPage([
            'programs' => [
                'page' => $programPage,
                'total_count' => $programSearchResult['total_items'],
                'total_pages' => $programSearchResult['total_pages'],
                'items' => $this->programRepository->findBy(['id' => $programSearchResult['ids']]),
            ],
            'providers' => [
                'page' => $providerPage,
                'total_count' => $providerSearchResult['total_items'],
                'total_pages' => $providerSearchResult['total_pages'],
                'items' => $this->providerRepository->findBy(['id' => $providerSearchResult['ids']]),
            ],
            'articles' => [
                'page' => $blogPage,
                'total_count' => $articleSearchResult['total_items'],
                'total_pages' => $articleSearchResult['total_pages'],
                'items' => $this->articleRepository->findBy(['id' => $articleSearchResult['ids']]),
            ],
            'favorite_provider_ids' => $this->getFavoriteProviderIds(),
        ], PagesKeys::SEARCH_PAGE_SLUG));
    }

    protected function getFavoriteProviderIds(): array
    {
        $favoriteProviderIds = [];

        if ($this->getUser()) {
            foreach ($this->getUser()->getFavoriteProviders() as $provider) {
                $favoriteProviderIds[] = $provider->getId();
            }
        }

        return $favoriteProviderIds;
    }
}
