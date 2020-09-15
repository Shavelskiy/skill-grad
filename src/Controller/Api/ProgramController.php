<?php

namespace App\Controller\Api;

use App\Dto\SearchQuery;
use App\Entity\Category;
use App\Entity\Program\Program;
use App\Entity\User;
use App\Repository\ProgramQuestionRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProgramRequestRepository;
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

    protected RouterInterface $router;
    protected ProgramRepository $programRepository;
    protected ProgramRequestRepository $programRequestRepository;
    protected ProgramQuestionRepository $programQuestionRepository;

    public function __construct(
        RouterInterface $router,
        ProgramRepository $programRepository,
        ProgramRequestRepository $programRequestRepository,
        ProgramQuestionRepository $programQuestionRepository
    ) {
        $this->router = $router;
        $this->programRepository = $programRepository;
        $this->programRequestRepository = $programRequestRepository;
        $this->programQuestionRepository = $programQuestionRepository;
    }

    /**
     * @Route("", methods={"GET"}, name="api.profile.programs.index")
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

        $searchResult = $this->programRepository->getPaginatorResult($query);

        $programs = [];

        /** @var Program $program */
        foreach ($searchResult->getItems() as $program) {
            $categories = [];

            /** @var Category $category */
            foreach ($program->getCategories() as $category) {
                $categories[] = $category->getName();
            }

            $programs[] = [
                'id' => $program->getId(),
                'link' => $this->router->generate('program.view', ['id' => $program->getId()]),
                'name' => $program->getName(),
                'categories' => implode(',', $categories),
                'requests' => [
                    'total' => $program->getRequests()->count(),
                ],
                'questions' => [
                    'total' => $program->getQuestions()->count(),
                ],
                'reviews' => [
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
}
