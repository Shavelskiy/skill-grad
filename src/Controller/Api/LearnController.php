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
use Doctrine\ORM\EntityManagerInterface;
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
    protected EntityManagerInterface $entityManger;
    protected ProgramRepository $programRepository;
    protected ProgramRequestRepository $programRequestRepository;
    protected ProgramReviewsRepository $programReviewRepository;

    public function __construct(
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        ProgramRepository $programRepository,
        ProgramRequestRepository $programRequestRepository,
        ProgramReviewsRepository $programReviewRepository
    ) {
        $this->router = $router;
        $this->entityManger = $entityManager;
        $this->programRepository = $programRepository;
        $this->programRequestRepository = $programRequestRepository;
        $this->programReviewRepository = $programReviewRepository;
    }

    /**
     * @Route("", name="api.learn.index", methods={"GET"})
     */
    public function index(Request $request): Response
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

        /** @var ProgramRequest $programRequest */
        foreach ($searchResult->getItems() as $programRequest) {
            $program = $programRequest->getProgram();
            $programId = $program->getId();

            if (isset($programs[$programId])) {
                continue;
            }

            $categories = [];

            /** @var Category $category */
            foreach ($program->getCategories() as $category) {
                $categories[] = $category->getName();
            }

            /** @var Provider $provider */
            $provider = $program->getProviders()[0];

            $programReview = null;

            /** @var ProgramReview $programReview */
            foreach ($program->getReviews() as $programReview) {
                if ($programReview->getUser()->getId() === $user->getId()) {
                    $programReview = [
                        'review' => $programReview->getReview(),
                        'rating' => $programReview->getRating(),
                    ];
                }
            }

            $programs[$programId] = [
                'id' => $programId,
                'name' => $program->getName(),
                'categories' => implode(',', $categories),
                'link' => $this->router->generate('program.view', ['id' => $program->getId()]),
                'date' => $programRequest->getCreatedAt()->format('c'),
                'review' => $programReview,
                'provider' => [
                    'name' => $provider->getName(),
                    'link' => $this->router->generate('provider.view', ['provider' => $provider->getId()]),
                ],
            ];
        }

        return new JsonResponse([
            'items' => array_values($programs),
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
        ]);
    }

    /**
     * @Route("/review", name="api.learn.review", methods={"POST"})
     */
    public function review(Request $request): Response
    {
        $programId = $request->get('id');
        $review = $request->get('review');

        $program = $this->programRepository->find($programId);

        /** @var User $user */
        $user = $this->getUser();

        $programReview = (new ProgramReview())
            ->setProgram($program)
            ->setUser($user)
            ->setRating($review['rating'])
            ->setReview($review['review']);

        $this->entityManger->persist($programReview);
        $this->entityManger->flush();

        return new JsonResponse([]);
    }
}
