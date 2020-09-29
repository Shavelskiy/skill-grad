<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    protected const PAGE_ITEM_COUNT = 10;

    protected SearchService $searchService;
    protected ArticleRepository $articleRepository;
    protected CategoryRepository $categoryRepository;
    protected SessionInterface $session;

    public function __construct(
        SearchService $searchService,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        SessionInterface $session
    ) {
        $this->searchService = $searchService;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->session = $session;
    }

    /**
     * @Route("", name="blog.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {

        $page = (int)$request->get('page', 1);

        $category = null;

        if (($categoryId = (int)$request->get('category')) > 0) {
            $category = $this->categoryRepository->find($categoryId);
        }

        $searchResult = $this->searchService->findArticles($page, $request->get('q', ''), $category ? $category->getId() : null);

        $userArticles = [];

        /** @var User $user */
        if (($user = $this->getUser()) && $user->isProvider()) {
            $userArticles = $this->articleRepository->findUserArticles($user);
        }

        return $this->render('blog/index.html.twig', [
            'articles' => $this->articleRepository->findBy(['id' => $searchResult['ids']]),
            'page' => $page,
            'total_pages' => $searchResult['total_pages'],
            'user_articles' => $userArticles,
        ]);
    }

    /**
     * @Route("/{article}", name="blog.view", methods={"GET"})
     */
    public function view(Article $article): Response
    {
        $userViewsArticle = $this->session->get('article.view', []);

        if (!in_array($article->getId(), $userViewsArticle, true)) {
            $article->setViews($article->getViews() + 1);
            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();

            $userViewsArticle[] = $article->getId();
            $this->session->set('article.view', $userViewsArticle);
        }

        $moreArticles = [];

        foreach ($this->articleRepository->findCategoriesArticles($article->getCategory(), 3) as $moreArticle) {
            if ($moreArticle->getId() !== $article->getId()) {
                $moreArticles[] = $moreArticle;
            }
        }

        return $this->render('blog/view.html.twig', [
            'article' => $article,
            'is_favorite' => $this->getUser() && $this->getUser()->getFavoriteArticles()->contains($article),
            'more_articles' => $moreArticles,
        ]);
    }
}
