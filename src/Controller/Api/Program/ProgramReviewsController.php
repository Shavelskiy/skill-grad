<?php

namespace App\Controller\Api\Program;

use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramReview;
use App\Repository\ProgramReviewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/profile/program/review")
 */
class ProgramReviewsController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected EntityManagerInterface $entityManager;
    protected ProgramReviewsRepository $programReviewsRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgramReviewsRepository $programReviewsRepository
    ) {
        $this->entityManager = $entityManager;
        $this->programReviewsRepository = $programReviewsRepository;
    }

    /**
     * @Route("/{program}", name="api/program.reviews.index", methods={"GET"})
     */
    public function indexAction(Program $program, Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->programReviewsRepository->getPaginatorResult($query, $program);

        $reviews = [];

        /** @var ProgramReview $programReview */
        foreach ($searchResult->getItems() as $programReview) {
            $reviews[] = [
                'id' => $programReview->getId(),
                'user_name' => $programReview->getUser()->getEmail(),
                'rating' => $programReview->getRating(),
                'average_rating' => $programReview->getAverageRating(),
                'review' => $programReview->getReview(),
                'answer' => $programReview->getAnswer(),
                'date' => $programReview->getCreatedAt()->format('c'),
            ];
        }

        return new JsonResponse([
            'items' => $reviews,
            'program_title' => $program->getName(),
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
        ]);
    }
}
