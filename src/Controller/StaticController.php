<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\User;
use App\Helpers\CompareHelper;
use App\Repository\ArticleRepository;
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

    protected ProviderRepository $providerRepository;
    protected FaqRepository $faqRepository;
    protected ProgramRepository $programRepository;
    protected ArticleRepository $articleRepository;

    public function __construct(
        ProviderRepository $providerRepository,
        FaqRepository $faqRepository,
        ProgramRepository $programRepository,
        ArticleRepository $articleRepository
    ) {
        $this->providerRepository = $providerRepository;
        $this->faqRepository = $faqRepository;
        $this->programRepository = $programRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/faq", name="faq.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $items = $this->faqRepository->findActiveItems();

        $selectedItemId = null;

        if (($id = (int)$request->get('id')) > 0) {
            foreach ($items as $item) {
                if ($item->getId() === $id) {
                    $selectedItemId = $item->getId();
                }
            }
        }

        return $this->render('static/faq.html.twig', [
            'items' => $items,
            'selected_item_id' => $selectedItemId,
        ]);
    }

    /**
     * @Route("/faq/student", name="faq.student", methods={"GET"})
     */
    public function studentFaq(): Response
    {
        return $this->render('static/student-faq.html.twig');
    }

    /**
     * @Route("/faq/provider", name="faq.provider", methods={"GET"})
     */
    public function providerFaq(): Response
    {
        return $this->render('static/provider-faq.html.twig');
    }

    /**
     * @Route("/compare", name="app.compare", methods={"GET"})
     */
    public function compare(Request $request): Response
    {
        $programIds = CompareHelper::getCompareProgramsFromParameterBag($request->cookies);

        return $this->render('static/compare.html.twig', [
            'programs' => $this->programRepository->findBy(['id' => $programIds]),
        ]);
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

        return $this->render('static/favorite.html.twig', [
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
        ]);
    }

    protected function getFavoriteCurrentTab(string $tab): string
    {
        if (!in_array($tab, [self::TAB_PROVIDER, self::TAB_PROGRAM, self::TAB_ARTICLE], true)) {
            return self::TAB_PROVIDER;
        }

        return $tab;
    }
}
