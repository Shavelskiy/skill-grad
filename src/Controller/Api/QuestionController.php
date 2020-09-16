<?php

namespace App\Controller\Api;

use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramQuestion;
use App\Repository\ProgramQuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/profile/program/question")
 */
class QuestionController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected EntityManagerInterface $entityManager;
    protected ProgramQuestionRepository $programQuestionRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgramQuestionRepository $programQuestionRepository
    ) {
        $this->entityManager = $entityManager;
        $this->programQuestionRepository = $programQuestionRepository;
    }

    /**
     * @Route("/{program}", name="api.question.index", methods={"GET"})
     */
    public function indexAction(Program $program, Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->programQuestionRepository->getPaginatorResult($query);

        $questions = [];

        /** @var ProgramQuestion $programQuestion */
        foreach ($searchResult->getItems() as $programQuestion) {
            $questions[] = [
                'id' => $programQuestion->getId(),
                'user_name' => $programQuestion->getUser()->getEmail(),
                'question' => $programQuestion->getQuestion(),
                'answer' => $programQuestion->getAnswer(),
                'date' => $programQuestion->getCreatedAt()->format('c'),
            ];
        }

        return new JsonResponse([
            'items' => $questions,
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
        ]);
    }

    /**
     * @Route("/answer/{programQuestion}", name="api.question.answer", methods={"POST"})
     */
    public function answerAction(ProgramQuestion $programQuestion, Request $request): Response
    {
        $programQuestion
            ->setAnswer($request->get('answer'));

        $this->entityManager->persist($programQuestion);
        $this->entityManager->flush();

        return new JsonResponse([]);
    }
}
