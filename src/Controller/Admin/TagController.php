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
    protected const DEFAULT_PAGE_ITEMS = 10;

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
            ->getPaginatorItems($page, is_array($order) ? $order : null, self::DEFAULT_PAGE_ITEMS);

        $items = [];

        foreach ($paginator->getItems() as $item) {
            $items[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'sort' => $item->getSort(),
            ];
        }

        $data = [
            'total_pages' => $paginator->getTotalPageCount(),
            'current_page' => $paginator->getCurrentPage(),
            'items' => $items,
        ];

        return new JsonResponse($data);
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

            if ($tag === null) {
                throw new \RuntimeException('');
            }

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

    /**
     * @Route("/", name="admin.tag.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        /** @var Tag $tag */
        $tag = $this->tagRepository->find($request->get('id'));

        if ($tag === null) {
            return new JsonResponse([], 404);
        }

        $tag
            ->setName($request->get('name'))
            ->setSort($request->get('sort'));

        $this->getDoctrine()->getManager()->persist($tag);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/", name="admin.tag.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        /** @var Tag $tag */
        $tag = $this->tagRepository->find($request->get('id'));

        if ($tag === null) {
            return new JsonResponse([], 404);
        }

        $this->getDoctrine()->getManager()->remove($tag);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }
}
