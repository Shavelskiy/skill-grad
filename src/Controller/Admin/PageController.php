<?php

namespace App\Controller\Admin;

use App\Entity\Content\Page;
use App\Helpers\SearchHelper;
use App\Repository\Content\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/page")
 */
class PageController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected PageRepository $pageRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        PageRepository $pageRepository
    ) {
        $this->entityManager = $entityManager;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @Route("", name="admin.page.index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        $searchQuery = SearchHelper::createFromRequest($request, [Page::class]);

        $paginator = $this->pageRepository->getPaginatorResult($searchQuery);

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

    protected function prepareItem(Page $item, bool $full = false): array
    {
        $data = [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'slug' => $item->getSlug(),
        ];

        if (!$full) {
            return $data;
        }

        return array_merge($data, [
            'content' => $item->getContent(),
        ]);
    }

    /**
     * @Route("/{page}", name="admin.page.view", methods={"GET"}, requirements={"page"="[0-9]+"})
     */
    public function view(Page $page): Response
    {
        return new JsonResponse(
            $this->prepareItem($page, true)
        );
    }

    /**
     * @Route("", name="admin.page.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        return $this->handleSaveItem(new Page(), $request);
    }

    /**
     * @Route("", name="admin.page.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        if (($page = $this->pageRepository->find($request->get('id'))) === null) {
            return new JsonResponse([], 404);
        }

        return $this->handleSaveItem($page, $request);
    }

    protected function handleSaveItem(Page $item, Request $request): Response
    {
        try {
            $item
                ->setTitle($request->get('title'))
                ->setSlug($request->get('slug'))
                ->setContent($request->get('content'));

            $this->entityManager->persist($item);
            $this->entityManager->flush();
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }

        return new JsonResponse();
    }

    /**
     * @Route("", name="admin.page.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        if (($page = $this->pageRepository->find($request->get('id'))) === null) {
            return new JsonResponse([], 404);
        }

        $this->entityManager->remove($page);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
