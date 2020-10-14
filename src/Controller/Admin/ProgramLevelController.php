<?php

namespace App\Controller\Admin;

use App\Entity\Program\ProgramLevel;
use App\Helpers\SearchHelper;
use App\Repository\ProgramLevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/program-level")
 */
class ProgramLevelController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected ProgramLevelRepository $programLevelRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgramLevelRepository $programLevelRepository
    ) {
        $this->entityManager = $entityManager;
        $this->programLevelRepository = $programLevelRepository;
    }

    /**
     * @Route("", name="admin.program-level.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [ProgramLevel::class]);

        $paginator = $this->programLevelRepository->getPaginatorResult($searchQuery);

        $items = [];
        foreach ($paginator->getItems() as $item) {
            $items[] = $this->prepareItem($item);
        }

        return new JsonResponse([
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ]);
    }

    protected function prepareItem(ProgramLevel $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getTitle(),
            'sort' => $item->getSort(),
        ];
    }

    /**
     * @Route("/{programLevel}", name="admin.program-level.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     */
    public function view(ProgramLevel $programLevel): Response
    {
        return new JsonResponse(
            $this->prepareItem($programLevel)
        );
    }

    /**
     * @Route("", name="admin.program-level.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $programLevel = (new ProgramLevel())
            ->setTitle($request->get('name'))
            ->setSort($request->get('sort'));

        $this->entityManager->persist($programLevel);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.program-level.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        /** @var ProgramLevel $programLevel */
        $programLevel = $this->programLevelRepository->find($request->get('id'));

        if ($programLevel === null) {
            return new JsonResponse([], 404);
        }

        $programLevel
            ->setTitle($request->get('name'))
            ->setSort($request->get('sort'));

        $this->entityManager->persist($programLevel);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.program-level.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        /** @var ProgramLevel $programLevel */
        $programLevel = $this->programLevelRepository->find($request->get('id'));

        if ($programLevel === null) {
            return new JsonResponse([], 404);
        }

        $this->entityManager->remove($programLevel);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
