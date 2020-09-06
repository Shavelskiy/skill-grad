<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\Program\Program;
use App\Repository\ProgramRepository;
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

    protected ProgramRepository $programRepository;
    protected ProgramService $programService;

    public function __construct(
        ProgramRepository $programRepository,
        ProgramService $programService
    ) {
        $this->programRepository = $programRepository;
        $this->programService = $programService;
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

//        $favoriteProviderIds = [];
//
//        if ($this->getUser()) {
//            foreach ($this->getUser()->getFavoriteProviders() as $provider) {
//                $favoriteProviderIds[] = $provider->getId();
//            }
//        }

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
//            'favorite_provider_ids' => $favoriteProviderIds,
        ]);
    }

    /**
     * @Route("/program/{id}", name="program.view", methods={"GET"})
     */
    public function actionView(int $id): Response
    {
        return $this->render('program/view.html.twig');
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
