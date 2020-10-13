<?php

namespace App\Controller;

use App\Controller\Traits\SeoTrait;
use App\Dto\SearchQuery;
use App\Entity\User;
use App\Enum\PagesKeys;
use App\Helpers\CompareHelper;
use App\Repository\ArticleRepository;
use App\Repository\Content\Seo\DefaultSeoRepository;
use App\Repository\FaqRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected const TAB_PROVIDER = 'providers';
    protected const TAB_PROGRAM = 'programs';
    protected const TAB_ARTICLE = 'articles';

    use SeoTrait;

    protected ProviderRepository $providerRepository;
    protected FaqRepository $faqRepository;
    protected ProgramRepository $programRepository;
    protected ArticleRepository $articleRepository;

    public function __construct(
        ProviderRepository $providerRepository,
        FaqRepository $faqRepository,
        ProgramRepository $programRepository,
        ArticleRepository $articleRepository,
        DefaultSeoRepository $defaultSeoRepository
    ) {
        $this->providerRepository = $providerRepository;
        $this->faqRepository = $faqRepository;
        $this->programRepository = $programRepository;
        $this->articleRepository = $articleRepository;

        $this->setDefaultSeoRepository($defaultSeoRepository);
    }

    /**
     * @Route("/faq", name="faq.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $query = $request->get('q', '');

        $items = $this->faqRepository->findActiveItems($query);

        $selectedItemId = null;

        if (($id = (int)$request->get('id')) > 0) {
            foreach ($items as $item) {
                if ($item->getId() === $id) {
                    $selectedItemId = $item->getId();
                }
            }
        }

        return $this->render('static/faq.html.twig', $this->applySeoToDefaultPage([
            'items' => $items,
            'selected_item_id' => $selectedItemId,
        ], PagesKeys::FAQ_PAGE));
    }

    /**
     * @Route("/faq/student", name="faq.student", methods={"GET"})
     */
    public function studentFaq(): Response
    {
        return $this->render('static/student-faq.html.twig', $this->applySeoToDefaultPage([], PagesKeys::FAQ_STUDENT_PAGE));
    }

    /**
     * @Route("/faq/provider", name="faq.provider", methods={"GET"})
     */
    public function providerFaq(): Response
    {
        return $this->render('static/provider-faq.html.twig', $this->applySeoToDefaultPage([], PagesKeys::FAQ_PROVIDER_PAGE));
    }

    /**
     * @Route("/compare", name="app.compare", methods={"GET"})
     */
    public function compare(Request $request): Response
    {
        $programIds = CompareHelper::getCompareProgramsFromParameterBag($request->cookies);

        return $this->render('static/compare.html.twig', $this->applySeoToDefaultPage([
            'programs' => $this->programRepository->findBy(['id' => $programIds]),
        ], PagesKeys::COMPARE_PAGE));
    }

    /**
     * @Route("/favorite", name="app.favorite", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function favorite(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $providerQuery = (new SearchQuery())
            ->setSearch(['favoriteUsers' => $user])
            ->setPage((int)($request->get('provider_page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $programQuery = (new SearchQuery())
            ->setSearch(['favoriteUsers' => $user])
            ->setPage((int)($request->get('program_page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $articleQuery = (new SearchQuery())
            ->setSearch(['favoriteUsers' => $user])
            ->setPage((int)($request->get('article_page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $providerSearchResult = $this->providerRepository->getPaginatorResult($providerQuery);
        $programSearchResult = $this->programRepository->getPaginatorResult($programQuery);
        $articleSearchResult = $this->articleRepository->getPaginatorResult($articleQuery);

        return $this->render('static/favorite.html.twig', $this->applySeoToDefaultPage([
            'tab' => $this->getFavoriteCurrentTab($request->get('tab', '')),
            'providers' => [
                'items' => $providerSearchResult->getItems(),
                'page' => $providerSearchResult->getCurrentPage(),
                'total_pages' => $providerSearchResult->getTotalPageCount(),
                'total_count' => $user->getFavoriteProviders()->count(),
            ],
            'programs' => [
                'items' => $programSearchResult->getItems(),
                'page' => $programSearchResult->getCurrentPage(),
                'total_pages' => $programSearchResult->getTotalPageCount(),
                'total_count' => $user->getFavoritePrograms()->count(),
            ],
            'articles' => [
                'items' => $articleSearchResult->getItems(),
                'page' => $articleSearchResult->getCurrentPage(),
                'total_pages' => $articleSearchResult->getTotalPageCount(),
                'total_count' => $user->getFavoriteArticles()->count(),
            ],
        ], PagesKeys::FAVORITE_PAGE));
    }

    protected function getFavoriteCurrentTab(string $tab): string
    {
        if (!in_array($tab, [self::TAB_PROVIDER, self::TAB_PROGRAM, self::TAB_ARTICLE], true)) {
            return self::TAB_PROVIDER;
        }

        return $tab;
    }
}
