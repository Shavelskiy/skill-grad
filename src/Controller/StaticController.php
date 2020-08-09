<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\User;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected ProviderRepository $providerRepository;

    public function __construct(
        ProviderRepository $providerRepository
    )
    {
        $this->providerRepository = $providerRepository;
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
    public function compareAction(): Response
    {
        return $this->render('static/compare.html.twig');
    }

    /**
     * @Route("/favorite", name="app.favorite", methods={"GET"})
     */
    public function favoriteAction(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $providerQuery = (new SearchQuery())
            ->setSearch(['favoriteUsers' => $user])
            ->setPage((int)($request->get('provider_page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $providerSearchResult = $this->providerRepository->getPaginatorResult($providerQuery);

        return $this->render('static/favorite.html.twig', [
            'providers' => [
                'items' => $providerSearchResult->getItems(),
                'page' => $providerSearchResult->getCurrentPage(),
                'total_pages' => $providerSearchResult->getTotalPageCount(),
                'total_count' => $user->getFavoriteProviders()->count(),
            ],
        ]);
    }
}
