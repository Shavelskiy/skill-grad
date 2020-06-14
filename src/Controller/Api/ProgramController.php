<?php

namespace App\Controller\Api;

use App\Dto\PaginatorResult;
use App\Entity\Category;
use App\Entity\Program;
use App\Entity\ProgramRequest;
use App\Repository\ProgramQuestionRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProgramRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/api/profile/programs")
 */
class ProgramController extends AbstractController
{
//    protected ProgramRepository $programRepository;
//    protected ProgramRequestRepository $programRequestRepository;
//    protected ProgramQuestionRepository $programQuestionRepository;
//
//    public function __construct(
//        ProgramRepository $programRepository,
//        ProgramRequestRepository $programRequestRepository,
//        ProgramQuestionRepository $programQuestionRepository
//    ) {
//        $this->programRepository = $programRepository;
//        $this->programRequestRepository = $programRequestRepository;
//        $this->programQuestionRepository = $programQuestionRepository;
//    }
//
//    /**
//     * @Route("/", methods={"GET"}, name="api.profile.programs.index")
//     */
//    public function index(Request $request): JsonResponse
//    {
//        $page = (int)($request->get('page', 1));
//        $active = (bool)($request->get('active', 1));
//
//        return new JsonResponse($this->getProgramData($page, $active));
//    }
//
//    /**
//     * @param $page
//     * @param $active
//     *
//     * @return array
//     */
//    protected function getProgramData($page, $active): array
//    {
//        $paginator = $this->programRepository
//            ->getPaginatorUserItems($this->getUser(), $active, $page);
//
//        return $this->getProgramDataFromPaginator($paginator);
//    }
//
//    /**
//     * @param PaginatorResult $paginator
//     *
//     * @return array
//     *
//     * @throws \Doctrine\ORM\NoResultException
//     * @throws \Doctrine\ORM\NonUniqueResultException
//     */
//    protected function getProgramDataFromPaginator(PaginatorResult $paginator): array
//    {
//        $data = [
//            'currentPage' => $paginator->getCurrentPage(),
//            'totalPages' => $paginator->getTotalPageCount(),
//            'items' => [],
//        ];
//
//        foreach ($paginator->getItems() as $program) {
//            $data['items'][] = $this->prepareProgramItem($program);
//        }
//
//        return $data;
//    }
//
//    /**
//     * @param Program $program
//     *
//     * @return array
//     *
//     * @throws \Doctrine\ORM\NoResultException
//     * @throws \Doctrine\ORM\NonUniqueResultException
//     */
//    protected function prepareProgramItem(Program $program): array
//    {
//        $categories = [];
//
//        /** @var Category $category */
//        foreach ($program->getCategories() as $category) {
//            $categories[] = $category->getName();
//        }
//
//        return [
//            'id' => $program->getId(),
//            'name' => $program->getName(),
//            'categories' => $categories,
//            'requests' => [
//                'total' => $this->programRequestRepository->getProgramRequestsCount($program),
//                'new' => $this->programRequestRepository->getNewProgramRequestsCount($program),
//            ],
//            'questions' => [
//                'total' => $this->programQuestionRepository->getProgramQuestionCount($program),
//                'new' => $this->programQuestionRepository->getNewProgramQuestionCount($program),
//            ],
//            'answers' => [
//                'total' => 0,
//                'new' => 0,
//            ],
//        ];
//    }
//
//    /**
//     * @Route("/requests", methods={"GET"}, name="api.profile.programs.requests")
//     */
//    public function getProgramRequests(Request $request): JsonResponse
//    {
//        $page = (int)($request->get('page', 1));
//        $programId = (int)$request->get('programId', null);
//
//        try {
//            return new JsonResponse($this->getProgramRequestData($programId, $page));
//        } catch (\Exception $e) {
//            return new JsonResponse($e->getMessage(), 400);
//        }
//    }
//
//    /**
//     * @param int|null $programId
//     * @param int      $page
//     *
//     * @return array
//     */
//    protected function getProgramRequestData(int $programId = null, int $page = 1): array
//    {
//        if ($programId === null) {
//            throw new NotFoundHttpException('Программа не найдена');
//        }
//
//        $program = $this->programRepository->find($programId);
//
//        if ($program === null) {
//            throw new NotFoundHttpException('Программа не найдена');
//        }
//
//        if ($program->getUser()->getId() !== $this->getUser()->getId()) {
//            throw new AccessDeniedException('У вас нет доступа для просмотра');
//        }
//
//        $paginator = $this->programRequestRepository
//            ->getPaginatorProgramItems($program, $page);
//
//        return array_merge(
//            ['programName' => $program->getName()],
//            $this->getRequestDataFromPaginator($paginator)
//        );
//    }
//
//    /**
//     * @param Paginator $paginator
//     *
//     * @return array
//     */
//    protected function getRequestDataFromPaginator(PaginatorResult $paginator): array
//    {
//        $data = [
//            'currentPage' => $paginator->getCurrentPage(),
//            'totalPages' => $paginator->getTotalPageCount(),
//            'items' => [],
//        ];
//
//        foreach ($paginator->getItems() as $programRequest) {
//            $data['items'][] = $this->prepareProgramRequestItem($programRequest);
//        }
//
//        return $data;
//    }
//
//    /**
//     * @param ProgramRequest $programRequest
//     *
//     * @return array
//     */
//    protected function prepareProgramRequestItem(ProgramRequest $programRequest): array
//    {
//        $author = $programRequest->getUser();
//
//        return [
//            'id' => $programRequest->getId(),
//            'date' => $programRequest->getCreated()->format('c'),
//            'author' => [
//                'name' => $author->getFullName(),
//                'email' => $author->getEmail(),
//                'phone' => $author->getPhone(),
//            ],
//            'comment' => $programRequest->getComment(),
//            'status' => $programRequest->getStatus(),
//        ];
//    }
}
