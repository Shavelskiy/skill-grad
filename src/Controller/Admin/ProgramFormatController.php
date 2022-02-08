<?php

namespace App\Controller\Admin;

use App\Entity\Program\ProgramFormat;
use App\Helpers\SearchHelper;
use App\Repository\ProgramFormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
    protected EntityManagerInterface $entityManager;
    protected ProgramFormatRepository $programFormatRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgramFormatRepository $programFormatRepository
    ) {
        $this->entityManager = $entityManager;
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

        return new JsonResponse([
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ]);
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
     * @Route("/{programFormat}", name="admin.program-format.view", methods={"GET"}, requirements={"programFormat"="[0-9]+"})
     */
    public function view(ProgramFormat $programFormat): Response
    {
        return new JsonResponse(
            $this->prepareItem($programFormat)
        );
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

        $this->entityManager->persist($programFormat);
        $this->entityManager->flush();

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

        $this->entityManager->persist($programFormat);
        $this->entityManager->flush();

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

        $this->entityManager->remove($programFormat);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
