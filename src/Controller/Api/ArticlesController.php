<?php

namespace App\Controller\Api;

use App\Dto\SearchQuery;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\UploadServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/api/article")
 */
class ArticlesController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected RouterInterface $router;
    protected UploadServiceInterface $uploadService;
    protected EntityManagerInterface $entityManager;
    protected ArticleRepository $articleRepository;
    protected CategoryRepository $categoryRepository;

    public function __construct(
        RouterInterface $router,
        UploadServiceInterface $uploadService,
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->router = $router;
        $this->uploadService = $uploadService;
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("", name="api.articles.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            return new JsonResponse([], 403);
        }

        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->articleRepository->getPaginatorResult($query);

        $articles = [];

        /** @var Article $article */
        foreach ($searchResult->getItems() as $article) {
            $articles[] = [
                'id' => $article->getId(),
                'name' => $article->getName(),
                'preview' => $article->getPreviewText(),
                'image' => $article->getImage()->getPublicPath(),
                'reading_time' => $article->getReadingTime(),
                'active' => $article->isActive(),
                'views' => $article->getViews(),
                'comments' => $article->getComments()->count(),
                'link' => $this->router->generate('blog.view', ['article' => $article->getId()]),
                'reviews' => [
                    'likes' => $article->getLikesCount(),
                    'dislikes' => $article->getDisLikesCount(),
                ],
                'date' => $article->getCreatedAt()->format('c'),
            ];
        }

        return new JsonResponse([
            'items' => array_values($articles),
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
        ]);
    }

    /**
     * @Route("/categories", name="api.articles.categories", methods={"GET"})
     */
    public function categories(): Response
    {
        $categories = [];

        foreach ($this->categoryRepository->findRootCategories() as $category) {
            $categories[] = [
                'value' => $category->getId(),
                'title' => $category->getName(),
            ];
        }

        return new JsonResponse($categories);
    }

    /**
     * @Route("/save", name="api.articles.save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        try {
            $image = $request->files->get('image');
            $upload = $this->uploadService->createUpload($image);
            $this->entityManager->persist($upload);

            $article = (new Article())
                ->setAuthor($this->getUser())
                ->setName($request->get('title'))
                ->setCategory(
                    $this->categoryRepository->find($request->get('category'))
                )
                ->setPreviewText($request->get('previewText'))
                ->setDetailText($request->get('detailText'))
                ->setImage($upload);

            $this->entityManager->persist($article);
            $this->entityManager->flush();
        } catch (Exception $e) {
            return new JsonResponse(['error' => 'При сохранении статьи произошла ошибка'], 400);
        }

        return new JsonResponse();
    }
}
