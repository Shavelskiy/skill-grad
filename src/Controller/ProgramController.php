<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Repository\ProgramReviewsRepository;
use App\Service\SearchService;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends BaseCatalogRepository
{
    protected const PAGE_ITEM_COUNT = 15;
    protected const PAGE_REVIEWS_COUNT = 5;

    protected ProgramRepository $programRepository;
    protected ProgramReviewsRepository $programReviewsRepository;

    public function __construct(
        SearchService $searchService,
        ProgramRepository $programRepository,
        ProgramReviewsRepository $programReviewsRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->searchService = $searchService;
        $this->programRepository = $programRepository;
        $this->programReviewsRepository = $programReviewsRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/program", name="program.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $page = $this->getPageFromRequest($request);


        $searchResult = $this->searchService->findPrograms(
            $page,
            $this->getQueryFromRequest($request),
            $this->getCategoriesFromRequest($request)
        );

        return $this->render('program/index.html.twig', [
            'programs' => $this->programRepository->findBy(['id' => $searchResult['ids']]),
            'page' => $page,
            'total_pages' => $searchResult['total_pages'],
        ]);
    }

    /**
     * @Route("/program/{id}", name="program.view", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function view(Program $program, Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_REVIEWS_COUNT);

        $searchResult = $this->programReviewsRepository->getPaginatorResult($query, $program);

        return $this->render('program/view.html.twig', [
            'program' => $program,
            'is_favorite' => $this->getUser() && $this->getUser()->getFavoritePrograms()->contains($program),
            'reviews' => [
                'items' => $searchResult->getItems(),
                'page' => $searchResult->getCurrentPage(),
                'total_pages' => $searchResult->getTotalPageCount(),
            ],
        ]);
    }

    /**
     * @Route("/program-create", name="program.add", methods={"GET"})
     * @IsGranted("ROLE_PROVIDER")
     */
    public function create(): Response
    {
        return $this->render('program/add.html.twig');
    }
}
