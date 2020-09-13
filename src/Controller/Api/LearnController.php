<?php

namespace App\Controller\Api;

use App\Dto\SearchQuery;
use App\Entity\Category;
use App\Entity\Program\ProgramRequest;
use App\Entity\Program\ProgramReview;
use App\Entity\Provider;
use App\Entity\User;
use App\Repository\ProgramRepository;
use App\Repository\ProgramRequestRepository;
use App\Repository\ProgramReviewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/api/learn")
 */
class LearnController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected RouterInterface $router;
    protected ProgramRepository $programRepository;
    protected ProgramRequestRepository $programRequestRepository;
    protected ProgramReviewsRepository $programReviewRepository;

    public function __construct(
        RouterInterface $router,
        ProgramRepository $programRepository,
        ProgramRequestRepository $programRequestRepository,
        ProgramReviewsRepository $programReviewRepository
    ) {
        $this->router = $router;
        $this->programRepository = $programRepository;
        $this->programRequestRepository = $programRequestRepository;
        $this->programReviewRepository = $programReviewRepository;
    }

    /**
     * @Route("", name="api.learn.index", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            return new JsonResponse([], 403);
        }

        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->programRequestRepository->getPaginatorResult($query, $user);

        $programs = [];
        $programIds = [];

        /** @var ProgramRequest $programRequest */
        foreach ($searchResult->getItems() as $programRequest) {
            $program = $programRequest->getProgram();
            $programIds[] = $program->getId();
            $categories = [];

            /** @var Category $category */
            foreach ($program->getCategories() as $category) {
                $categories[] = $category->getName();
            }

            /** @var Provider $provider */
            $provider = $program->getProviders()[0];

            $programs[] = [
                'id' => $program->getId(),
                'name' => $program->getName(),
                'categories' => implode(',', $categories),
                'link' => $this->router->generate('program.view', ['id' => $program->getId()]),
                'date' => $programRequest->getCreatedAt()->format('c'),
                'provider' => [
                    'name' => $provider->getName(),
                    'link' => $this->router->generate('provider.view', ['id' => $provider->getId()]),
                ],
            ];
        }

        $programReviews = [];

        /** @var ProgramReview $programReview */
        foreach ($this->programReviewRepository->findBy(['id' => $programIds]) as $programReview) {
            $programReviews[] = [
                'id' => $programReview->getId(),
            ];
        }

        return new JsonResponse([
            'programs' => $programs,
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
            'programReviews' => $programReviews,
        ]);
    }
}
