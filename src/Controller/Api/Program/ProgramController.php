<?php

namespace App\Controller\Api\Program;

use App\Dto\SearchQuery;
use App\Entity\Category;
use App\Entity\Program\Program;
use App\Entity\Program\ProgramQuestion;
use App\Entity\Program\ProgramRequest;
use App\Entity\Program\ProgramReview;
use App\Entity\User;
use App\Repository\ProgramQuestionRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProgramRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/api/profile/program")
 */
class ProgramController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected EntityManagerInterface $entityManager;
    protected RouterInterface $router;
    protected ProgramRepository $programRepository;
    protected ProgramRequestRepository $programRequestRepository;
    protected ProgramQuestionRepository $programQuestionRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        ProgramRepository $programRepository,
        ProgramRequestRepository $programRequestRepository,
        ProgramQuestionRepository $programQuestionRepository
    ) {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->programRepository = $programRepository;
        $this->programRequestRepository = $programRequestRepository;
        $this->programQuestionRepository = $programQuestionRepository;
    }

    /**
     * @Route("", methods={"GET"}, name="api.profile.programs.index")
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            return new JsonResponse([], 403);
        }

        $query = (new SearchQuery())
            ->setSearch([
                'author' => $user,
                'active' => (bool)$request->get('active'),
            ])
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->programRepository->getPaginatorResult($query);

        $programs = [];

        /** @var Program $program */
        foreach ($searchResult->getItems() as $program) {
            $programs[] = [
                'id' => $program->getId(),
                'link' => $this->router->generate('program.view', ['id' => $program->getId()]),
                'name' => $program->getName(),
                'categories' => implode(',', $program->getCategories()->map(fn(Category $category) => $category->getName())->toArray()),
                'active' => $program->isActive(),
                'requests' => [
                    'new' => $program
                        ->getRequests()
                        ->filter(fn(ProgramRequest $request) => $request->getStatus() === ProgramRequest::STATUS_NEW)
                        ->count(),
                    'total' => $program->getRequests()->count(),
                ],
                'questions' => [
                    'new' => $program
                        ->getQuestions()
                        ->filter(fn(ProgramQuestion $question) => $question->getAnswer() === null)
                        ->count(),
                    'total' => $program->getQuestions()->count(),
                ],
                'reviews' => [
                    'new' => $program
                        ->getReviews()
                        ->filter(fn(ProgramReview $review) => $review->getAnswer() === null)
                        ->count(),
                    'total' => $program->getReviews()->count(),
                ],
            ];
        }

        return new JsonResponse([
            'items' => $programs,
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
        ]);
    }

    /**
     * @Route("/prices", name="api.profile.programs.prices", methods={"GET"})
     */
    public function prices(): Response
    {
        return new JsonResponse([
            'highlight' => 990,
            'raise' => 490,
            'highlight_raise' => 1290,
        ]);
    }

    /**
     * @Route("/deactivate/{program}", name="api.profile.programs.deactivate", methods={"POST"})
     */
    public function deactivate(Program $program): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            return new JsonResponse([], 403);
        }

        if ($program->getAuthor()->getId() !== $user->getId()) {
            return new JsonResponse([], 403);
        }

        if (!$program->isActive()) {
            return new JsonResponse([], 400);
        }

        $program->setActive(false);

        $this->entityManager->persist($program);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/activate/{program}", name="api.profile.programs.activate", methods={"POST"})
     */
    public function activate(Program $program): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            return new JsonResponse([], 403);
        }

        if ($program->getAuthor()->getId() !== $user->getId()) {
            return new JsonResponse([], 403);
        }

        if ($program->isActive()) {
            return new JsonResponse([], 400);
        }

        $program->setActive(true);

        $this->entityManager->persist($program);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
