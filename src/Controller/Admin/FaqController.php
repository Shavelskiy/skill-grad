<?php

namespace App\Controller\Admin;

use App\Entity\Content\Faq;
use App\Helpers\SearchHelper;
use App\Repository\Content\FaqRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/faq")
 */
class FaqController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected FaqRepository $faqRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        FaqRepository $faqRepository
    ) {
        $this->entityManager = $entityManager;
        $this->faqRepository = $faqRepository;
    }

    /**
     * @Route("", name="admin.faq.index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {
        $searchQuery = SearchHelper::createFromRequest($request, [Faq::class]);

        $paginator = $this->faqRepository->getPaginatorResult($searchQuery);

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

    protected function prepareItem(Faq $item, bool $full = false): array
    {
        $data = [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'sort' => $item->getSort(),
            'active' => $item->isActive(),
        ];

        if (!$full) {
            return $data;
        }

        return array_merge($data, [
            'content' => $item->getContent(),
        ]);
    }

    /**
     * @Route("/{faq}", name="admin.faq.view", methods={"GET"}, requirements={"faq"="[0-9]+"})
     */
    public function view(Faq $faq): Response
    {
        return new JsonResponse(
            $this->prepareItem($faq, true)
        );
    }

    /**
     * @Route("", name="admin.faq.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {

    }

    /**
     * @Route("", name="admin.faq.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {

    }

    /**
     * @Route("", name="admin.faq.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {

    }
}
