<?php

namespace App\Controller\Admin;

use App\Entity\Program\ProgramFormat;
use App\Helpers\SearchHelper;
use App\Repository\ProgramFormatRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/program-format")
 */
class ProgramFormatController extends AbstractController
{
    protected ProgramFormatRepository $programFormatRepository;

    public function __construct(
        ProgramFormatRepository $programFormatRepository
    ) {
        $this->programFormatRepository = $programFormatRepository;
    }

    /**
     * @Route("", name="admin.program-format.index", methods={"GET"})
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [ProgramFormat::class]);

        $paginator = $this->programFormatRepository->getPaginatorResult($searchQuery);

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

    protected function prepareItem(ProgramFormat $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'active' => $item->isActive(),
            'sort' => $item->getSort(),
        ];
    }

    /**
     * @Route("/{id}", name="admin.program-format.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     *
     * @param Request $request
     */
    public function view(int $id): Response
    {
        if ($id < 1) {
            throw new RuntimeException('');
        }

        /** @var ProgramFormat $programFormat */
        $programFormat = $this->programFormatRepository->find($id);

        if ($programFormat === null) {
            throw new RuntimeException('');
        }

        return new JsonResponse([
            'id' => $programFormat->getId(),
            'name' => $programFormat->getName(),
            'active' => $programFormat->isActive(),
            'sort' => $programFormat->getSort(),
        ]);
    }

    /**
     * @Route("", name="admin.program-format.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $programFormat = (new ProgramFormat())
            ->setName($request->get('name'))
            ->setActive($request->get('active'))
            ->setSort($request->get('sort'));

        $this->getDoctrine()->getManager()->persist($programFormat);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.program-format.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        /** @var ProgramFormat $programFormat */
        $programFormat = $this->programFormatRepository->find($request->get('id'));

        if ($programFormat === null) {
            return new JsonResponse([], 404);
        }

        $programFormat
            ->setName($request->get('name'))
            ->setActive($request->get('active'))
            ->setSort($request->get('sort'));

        $this->getDoctrine()->getManager()->persist($programFormat);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.program-format.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        /** @var ProgramFormat $programFormat */
        $programFormat = $this->programFormatRepository->find($request->get('id'));

        if ($programFormat === null) {
            return new JsonResponse([], 404);
        }

        $this->getDoctrine()->getManager()->remove($programFormat);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }
}
