<?php

namespace App\Controller\Admin;

use App\Entity\ProgramAdditional;
use App\Helpers\SearchHelper;
use App\Repository\ProgramAdditionalRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/program-additional")
 */
class ProgramAdditionalController extends AbstractController
{
    protected ProgramAdditionalRepository $programAdditionalRepository;

    public function __construct(
        ProgramAdditionalRepository $programAdditionalRepository
    )
    {
        $this->programAdditionalRepository = $programAdditionalRepository;
    }

    /**
     * @Route("", name="admin.program-additional.index", methods={"GET"})
     *
     * @param Request $request
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [ProgramAdditional::class]);

        $paginator = $this->programAdditionalRepository->getPaginatorResult($searchQuery);

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

    protected function prepareItem(ProgramAdditional $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getTitle(),
            'active' => $item->isActive(),
            'sort' => $item->getSort(),
        ];
    }

    /**
     * @Route("/{id}", name="admin.program-additional.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     * @param Request $request
     * @return Response
     */
    public function view(int $id): Response
    {
        if ($id < 1) {
            throw new RuntimeException('');
        }

        /** @var ProgramAdditional $programAdditional */
        $programAdditional = $this->programAdditionalRepository->find($id);

        if ($programAdditional === null) {
            throw new RuntimeException('');
        }

        return new JsonResponse([
            'id' => $programAdditional->getId(),
            'name' => $programAdditional->getTitle(),
            'active' => $programAdditional->isActive(),
            'sort' => $programAdditional->getSort(),
        ]);
    }

    /**
     * @Route("", name="admin.program-additional.create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $programAdditional = (new ProgramAdditional())
            ->setTitle($request->get('name'))
            ->setActive($request->get('active'))
            ->setSort($request->get('sort'));

        $this->getDoctrine()->getManager()->persist($programAdditional);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.program-additional.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        /** @var ProgramAdditional $programAdditional */
        $programAdditional = $this->programAdditionalRepository->find($request->get('id'));

        if ($programAdditional === null) {
            return new JsonResponse([], 404);
        }

        $programAdditional
            ->setTitle($request->get('name'))
            ->setActive($request->get('active'))
            ->setSort($request->get('sort'));

        $this->getDoctrine()->getManager()->persist($programAdditional);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.program-additional.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        /** @var ProgramAdditional $programAdditional */
        $programAdditional = $this->programAdditionalRepository->find($request->get('id'));

        if ($programAdditional === null) {
            return new JsonResponse([], 404);
        }

        $this->getDoctrine()->getManager()->remove($programAdditional);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }
}
