<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Repository\ProviderRepository;
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

    public function __construct(
        ProviderRepository $providerRepository
    )
    {
        $this->providerRepository = $providerRepository;
    }

    /**
     * @Route("", name="provider.index", methods={"GET"})
     */
    public function actionIndex(Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->providerRepository->getPaginatorResult($query);

        $favoriteProviderIds = [];

        if ($this->getUser()) {
            foreach ($this->getUser()->getFavoriteProviders() as $provider) {
                $favoriteProviderIds[] = $provider->getId();
            }
        }

        return $this->render('provider/index.html.twig', [
            'providers' => $searchResult->getItems(),
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
            'favorite_provider_ids' => $favoriteProviderIds,
        ]);
    }

    /**
     * @Route("/{id}", name="provider.view", methods={"GET"})
     */
    public function actionView(int $id): Response
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
