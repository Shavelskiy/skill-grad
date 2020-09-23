<?php

namespace App\Controller\Api;

use App\Dto\SearchQuery;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    protected EntityManagerInterface $entityManger;
    protected ArticleRepository $articleRepository;
    protected CategoryRepository $categoryRepository;

    public function __construct(
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->router = $router;
        $this->entityManger = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("", name="api.articles.index", methods={"GET"})
     */
    public function indexAction(Request $request): Response
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
                'reading_time' => 10,
                'active' => $article->isActive(),
                'views' => $article->getViews(),
                'comments' => 3,
                'link' => $this->router->generate('blog.view', ['id' => $article->getId()]),
                'reviews' => [
                    'likes' => 3,
                    'dislikes' => 6,
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
    public function categoriesAction(): Response
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
}
