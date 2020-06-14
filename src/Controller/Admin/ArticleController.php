<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Upload;
use App\Helpers\SearchHelper;
use App\Repository\ArticleRepository;
use App\Service\UploadServiceInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/article")
 */
class ArticleController extends AbstractController
{
    protected ArticleRepository $articleRepository;
    protected UploadServiceInterface $uploadService;

    public function __construct(ArticleRepository $articleRepository, UploadServiceInterface $uploadService)
    {
        $this->articleRepository = $articleRepository;
        $this->uploadService = $uploadService;
    }

    /**
     * @Route("", name="admin.artice.index", methods={"GET"})
     * @param Request $request
     * @return Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(Request $request): Response
    {
        $searchQuery = SearchHelper::createFromRequest($request, [Article::class]);

        $paginator = $this->articleRepository->getPaginatorResult($searchQuery);

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

    public function prepareItem(Article $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'slug' => $item->getSlug(),
            'sort' => $item->getSort(),
            'active' => $item->isActive(),
            'image' => ($item->getImage() !== null) ? $item->getImage()->getPublicPath() : null,
            'show_on_main' => $item->isShowOnMain(),
            'created_at' => $item->getCreatedAt()->format('d.m.Y')
        ];
    }

    /**
     * @Route("/{id}", name="admin.article.view", methods={"GET"}, requirements={"id"="[0-9]+"})
     * @param Request $request
     * @return Response
     */
    public function view(int $id): Response
    {
        try {
            if ($id < 1) {
                throw new RuntimeException('');
            }

            /** @var Article $article */
            $article = $this->articleRepository->find($id);

            if ($article === null) {
                throw new RuntimeException('');
            }

            return new JsonResponse([
                'id' => $article->getId(),
                'name' => $article->getName(),
                'slug' => $article->getSlug(),
                'sort' => $article->getSort(),
                'active' => $article->isActive(),
                'image' => ($article->getImage() !== null) ? $article->getImage()->getPublicPath() : null,
                'detail_text' => $article->getDetailText(),
                'show_on_main' => $article->isShowOnMain(),
                'created_at' => $article->getCreatedAt()->format('d.m.Y')
            ]);
        } catch (Exception $e) {
            throw new NotFoundHttpException('');
        }
    }

    /**
     * @Route("", name="admin.article.create", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $article = (new Article())
            ->setName($request->get('name'))
            ->setSlug($request->get('slug'))
            ->setSort($request->get('sort'))
            ->setActive($request->get('active') === 'true')
            ->setDetailText($request->get('detailText'))
            ->setShowOnMain($request->get('showOnMain') === 'true');

        try {
            /** @var UploadedFile $uploadImage */
            if ($uploadImage = $request->files->get('uploadImage')) {
                $fileName = uniqid('', true) . '-' . time() . '.' . $uploadImage->guessExtension();

                try {
                    $uploadImage->move($this->getParameter('upload_dir'), $fileName);
                } catch (Exception $e) {
                    throw new RuntimeException('Ошибка при сохранении файла');
                }

                $articleImage = (new Upload())->setName($fileName);
                $article->setImage($articleImage);

                $this->getDoctrine()->getManager()->persist($articleImage);
            }

            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse();
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @Route("", name="admin.article.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        /** @var Article $article */
        $article = $this->articleRepository->find($request->get('id'));

        if ($article === null) {
            return new JsonResponse([], 404);
        }

        $article
            ->setName($request->get('name'))
            ->setSlug($request->get('slug'))
            ->setSort($request->get('sort'))
            ->setActive($request->get('active') === 'true')
            ->setDetailText($request->get('detailText'))
            ->setShowOnMain($request->get('showOnMain') === 'true');

        try {
            /** @var UploadedFile $uploadImage */
            $uploadImage = $request->files->get('uploadImage');

            if ($uploadImage || $request->get('image') === 'null') {
                $oldImage = $article->getImage();
                if ($oldImage !== null) {
                    $article->setImage(null);
                    $this->uploadService->deleteUpload($oldImage);
                }
            }

            if ($uploadImage) {
                $uploadImage = new UploadedFile(
                    $uploadImage->getPathname(),
                    $uploadImage->getClientOriginalName(),
                    $uploadImage->getMimeType(),
                    $uploadImage->getError(),
                    true
                );

                $fileName = uniqid('', true) . '-' . time() . '.' . $uploadImage->guessExtension();

                try {
                    $uploadImage->move($this->getParameter('upload_dir'), $fileName);
                } catch (Exception $e) {
                    throw new RuntimeException('Ошибка при сохранении файла');
                }

                $articleImage = (new Upload())->setName($fileName);
                $article->setImage($articleImage);

                $this->getDoctrine()->getManager()->persist($articleImage);
            }

            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse();
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * @Route("", name="admin.article.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {
        /** @var Article $article */
        $article = $this->articleRepository->find($request->get('id'));

        if ($article === null) {
            return new JsonResponse([], 404);
        }

        $this->getDoctrine()->getManager()->remove($article);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse();
    }
}
