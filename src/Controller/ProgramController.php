<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Repository\ProgramRepository;
use App\Repository\ProgramReviewsRepository;
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
    protected ProgramReviewsRepository $programReviewsRepository;

    public function __construct(
        ProgramRepository $programRepository,
        ProgramReviewsRepository $programReviewsRepository
    ) {
        $this->programRepository = $programRepository;
        $this->programReviewsRepository = $programReviewsRepository;
    }

    /**
     * @Route("/program", name="program.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->programRepository->getPaginatorResult($query);

        return $this->render('program/index.html.twig', [
            'programs' => $searchResult->getItems(),
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
    public function view(Program $program, Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_REVIEWS_COUNT);

        $searchResult = $this->programReviewsRepository->getPaginatorResult($query, $program);
        $reviews = $searchResult->getItems();

        $isFavorite = false;

        if ($this->getUser()) {
            $isFavorite = $this->getUser()->getFavoritePrograms()->contains($program);
        }
        return $this->render('program/view.html.twig', [
            'program' => $program,
            'is_favorite' => $isFavorite,
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
    public function create(): Response
    {
        return $this->render('program/add.html.twig');
    }
}
