<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Repository\ProgramRepository;
use App\Repository\ProgramReviewsRepository;
use App\Service\ProgramService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 15;
    protected const PAGE_REVIEWS_COUNT = 5;

    protected ProgramRepository $programRepository;
    protected ProgramService $programService;
    protected ProgramReviewsRepository $programReviewsRepository;

    public function __construct(
        ProgramRepository $programRepository,
        ProgramService $programService,
        ProgramReviewsRepository $programReviewsRepository
    ) {
        $this->programRepository = $programRepository;
        $this->programService = $programService;
        $this->programReviewsRepository = $programReviewsRepository;
    }

    /**
     * @Route("/program", name="program.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function indexAction(Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->programRepository->getPaginatorResult($query);

        $programs = [];

        /** @var Program $program */
        foreach ($searchResult->getItems() as $program) {
            $programs[] = [
                'item' => $program,
                'additional' => $this->programService->prepareProgramCard($program),
            ];
        }

        return $this->render('program/index.html.twig', [
            'programs' => $programs,
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
        ]);
    }

    /**
     * @Route("/program/{id}", name="program.view", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function actionView(Program $program, Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_REVIEWS_COUNT);

        $searchResult = $this->programReviewsRepository->getPaginatorResult($query);
        $reviews = $searchResult->getItems();

        return $this->render('program/view.html.twig', [
            'program' => $program,
            'additional' => $this->programService->prepareProgramCard($program),
            'reviews' => [
                'items' => $reviews,
                'page' => $searchResult->getCurrentPage(),
                'total_pages' => $searchResult->getTotalPageCount(),
            ],
        ]);
    }

    /**
     * @Route("/program-create", name="program.add", methods={"GET"})
     * @IsGranted("ROLE_PROVIDER")
     */
    public function createAction(): Response
    {
        return $this->render('program/add.html.twig');
    }
}
