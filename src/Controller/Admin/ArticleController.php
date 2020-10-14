<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Helpers\SearchHelper;
use App\Repository\ArticleRepository;
use App\Service\UploadServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/article")
 */
class ArticleController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected ArticleRepository $articleRepository;
    protected UploadServiceInterface $uploadService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        UploadServiceInterface $uploadService
    ) {
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->uploadService = $uploadService;
    }

    /**
     * @Route("", name="admin.artice.index", methods={"GET"})
     *
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
            'sort' => $item->getSort(),
            'active' => $item->isActive(),
            'image' => ($item->getImage() !== null) ? $item->getImage()->getPublicPath() : null,
            'showOnMain' => $item->isShowOnMain(),
            'created_at' => $item->getCreatedAt()->format('d.m.Y'),
        ];
    }

    /**
     * @Route("/{article}", name="admin.article.view", methods={"GET"}, requirements={"article"="[0-9]+"})
     */
    public function view(Article $article): Response
    {
        return new JsonResponse(
            $this->prepareItem($article)
        );
    }

    /**
     * @Route("", name="admin.article.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $article = (new Article())
            ->setName($request->get('name'))
            ->setSort($request->get('sort'))
            ->setActive($request->get('active'))
            ->setDetailText($request->get('detailText'))
            ->setShowOnMain($request->get('showOnMain'));

        try {
            /** @var UploadedFile $uploadImage */
            if ($uploadImage = $request->files->get('uploadImage')) {
                $articleImage = $this->uploadService->createUpload($uploadImage);
                $article->setImage($articleImage);

                $this->entityManager->persist($articleImage);
            }

            $this->entityManager->persist($article);
            $this->entityManager->flush();

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
        $article = $this->articleRepository->find($request->get('id'));

        if ($article === null) {
            return new JsonResponse([], 404);
        }

        $article
            ->setName($request->get('name'))
            ->setSort($request->get('sort'))
            ->setActive($request->get('active'))
            ->setDetailText($request->get('detailText'))
            ->setShowOnMain($request->get('showOnMain'));

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
                $uploadImage = $this->uploadService->createTestUpload($uploadImage);
                $articleImage = $this->uploadService->createUpload($uploadImage);
                $article->setImage($articleImage);

                $this->entityManager->persist($articleImage);
            }

            $this->entityManager->persist($article);
            $this->entityManager->flush();

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
        $article = $this->articleRepository->find($request->get('id'));

        if ($article === null) {
            return new JsonResponse([], 404);
        }

        $this->entityManager->remove($article);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
