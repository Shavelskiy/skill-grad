<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/tag")
 */
class TagController extends AbstractController
{
    protected TagRepository $tagRepository;

    public function __construct(
        TagRepository $tagRepository
    ) {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @Route("/", name="admin.tag.index", methods={"GET", "HEAD"})
     */
    public function index(Request $request): Response
    {
        $page = (int)$request->get('page', 1);
        $order = json_decode($request->get('order', ''), true);

        $paginator = $this->tagRepository
            ->getPaginatorItems($page, $order);

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

    /**
     * @param Tag $item
     * @return array
     */
    protected function prepareItem(Tag $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'sort' => $item->getSort(),
        ];
    }

    /**
     * @Route("/{id}", name="admin.tag.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     *
     * @param int $id
     * @return Response
     */
    public function view(int $id): Response
    {
        try {
            if ($id < 1) {
                throw new \RuntimeException('');
            }

            /** @var Tag $tag */
            $tag = $this->tagRepository->find($id);

            return new JsonResponse([
                'id' => $tag->getId(),
                'name' => $tag->getName(),
                'sort' => $tag->getSort(),
            ]);
        } catch (\Exception $e) {
            throw new NotFoundHttpException('');
        }
    }

    /**
     * @Route("/", name="admin.tag.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $tag = (new Tag())
            ->setName($request->get('name'))
            ->setSort($request->get('sort'));

        $this->getDoctrine()->getManager()->persist($tag);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }


}
