<?php

namespace App\Controller\Admin;

use App\Entity\ProgramInclude;
use App\Helpers\SearchHelper;
use App\Repository\ProgramIncludeRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use RuntimeException;
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
    protected ProgramIncludeRepository $programIncludeRepository;

    public function __construct(
        ProgramIncludeRepository $programIncludeRepository
    )
    {
        $this->programIncludeRepository = $programIncludeRepository;
    }

    /**
     * @Route("", name="admin.program-include.index", methods={"GET"})
     *
     * @param Request $request
     * @return Response
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

        $data = [
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ];

        return new JsonResponse($data);
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
     * @Route("/{id}", name="admin.program-include.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     * @param Request $request
     * @return Response
     */
    public function view(int $id): Response
    {
        if ($id < 1) {
            throw new RuntimeException('');
        }

        /** @var ProgramInclude $programInclude */
        $programInclude = $this->programIncludeRepository->find($id);

        if ($programInclude === null) {
            throw new RuntimeException('');
        }

        return new JsonResponse([
            'id' => $programInclude->getId(),
            'name' => $programInclude->getTitle(),
            'active' => $programInclude->isActive(),
            'sort' => $programInclude->getSort(),
        ]);
    }

    /**
     * @Route("", name="admin.program-include.create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $programInclude = (new ProgramInclude())
            ->setTitle($request->get('name'))
            ->setActive($request->get('active'))
            ->setSort($request->get('sort'));

        $this->getDoctrine()->getManager()->persist($programInclude);
        $this->getDoctrine()->getManager()->flush();

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

        $this->getDoctrine()->getManager()->persist($programInclude);
        $this->getDoctrine()->getManager()->flush();

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

        $this->getDoctrine()->getManager()->remove($programInclude);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }
}
