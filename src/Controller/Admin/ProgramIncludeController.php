<?php

namespace App\Controller\Admin;

use App\Entity\Program\ProgramInclude;
use App\Helpers\SearchHelper;
use App\Repository\ProgramIncludeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/program-include")
 */
class ProgramIncludeController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected ProgramIncludeRepository $programIncludeRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgramIncludeRepository $programIncludeRepository
    ) {
        $this->entityManager = $entityManager;
        $this->programIncludeRepository = $programIncludeRepository;
    }

    /**
     * @Route("", name="admin.program-include.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [ProgramInclude::class]);

        $paginator = $this->programIncludeRepository->getPaginatorResult($searchQuery);

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

    protected function prepareItem(ProgramInclude $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getTitle(),
            'active' => $item->isActive(),
            'sort' => $item->getSort(),
        ];
    }

    /**
     * @Route("/{programInclude}", name="admin.program-include.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     */
    public function view(ProgramInclude $programInclude): Response
    {
        return new JsonResponse(
            $this->prepareItem($programInclude)
        );
    }

    /**
     * @Route("", name="admin.program-include.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $programInclude = (new ProgramInclude())
            ->setTitle($request->get('name'))
            ->setActive($request->get('active'))
            ->setSort($request->get('sort'));

        $this->entityManager->persist($programInclude);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.program-include.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        /** @var ProgramInclude $programInclude */
        $programInclude = $this->programIncludeRepository->find($request->get('id'));

        if ($programInclude === null) {
            return new JsonResponse([], 404);
        }

        $programInclude
            ->setTitle($request->get('name'))
            ->setActive($request->get('active'))
            ->setSort($request->get('sort'));

        $this->entityManager->persist($programInclude);
        $this->entityManager->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.program-include.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        /** @var ProgramInclude $programInclude */
        $programInclude = $this->programIncludeRepository->find($request->get('id'));

        if ($programInclude === null) {
            return new JsonResponse([], 404);
        }

        $this->entityManager->remove($programInclude);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
