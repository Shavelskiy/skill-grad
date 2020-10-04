<?php

namespace App\Controller\Api;

use App\Dto\SearchQuery;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/payments")
 */
class PaymentsController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    /**
     * @Route("", name="api.payments.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        return new JsonResponse([
            'items' => [[], [], [], [], [], [], [], [], [], []],
            'page' => $query->getPage(),
            'total_pages' => 6,
        ]);
    }

    /**
     * @Route("/balance", name="api.payments.balance", methods={"GET"})
     */
    public function balance(): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            return new JsonResponse([], 403);
        }

        if (($provider = $user->getProvider()) === null) {
            return new JsonResponse([], 403);
        }

        return new JsonResponse([
            'balance' => $provider->getBalance(),
        ]);
    }
}
