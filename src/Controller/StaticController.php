<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\User;
use App\Helpers\CompareHelper;
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
    protected ProgramRepository $programRepository;

    public function __construct(
        ProviderRepository $providerRepository,
        ProgramRepository $programRepository
    ) {
        $this->providerRepository = $providerRepository;
        $this->programRepository = $programRepository;
    }

    /**
     * @Route("/faq", name="faq.index", methods={"GET"})
     */
    public function actionIndex(): Response
    {
        return $this->render('static/faq.html.twig');
    }

    /**
     * @Route("/faq/student", name="faq.student", methods={"GET"})
     */
    public function studentAction(): Response
    {
        return $this->render('static/student-faq.html.twig');
    }

    /**
     * @Route("/faq/provider", name="faq.provider", methods={"GET"})
     */
    public function providerAction(): Response
    {
        return $this->render('static/provider-faq.html.twig');
    }

    /**
     * @Route("/compare", name="app.compare", methods={"GET"})
     */
    public function compareAction(Request $request): Response
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
    public function favoriteAction(Request $request): Response
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

        $providerSearchResult = $this->providerRepository->getPaginatorResult($providerQuery);
        $programSearchResult = $this->programRepository->getPaginatorResult($programQuery);

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
