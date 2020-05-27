<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
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
     * @param Request $request
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
     * @Route("/create", name="admin.tag.create", methods={"GET", "HEAD"})
     */
    public function create(): Response
    {
        $tag = new Tag();

        /** @var Tag $maxSortTag */
        $maxSortTag = $this->getRepository()->getTagWithMaxSort();
        $tag->setSort(($maxSortTag !== null) ? ($maxSortTag->getSort() + 100) : 100);

        return $this->render('admin/tag/create.html.twig', [
            'form' => $this->getForm($tag)->createView(),
        ]);
    }

    /**
     * @Route("/create", name="admin.tag.store", methods={"POST", "PUT"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request): Response
    {
        $form = $this->getForm()->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('admin.tag.index');
        }

        return $this->render('admin/tag/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.tag.edit", methods={"GET", "HEAD"}, requirements={"id"="[0-9]+"})
     *
     * @param $id
     *
     * @return Response
     */
    public function edit($id): Response
    {
        $tag = $this->findModel($id);

        return $this->render('admin/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $this->getForm($tag)->createView(),
        ]);
    }


}
