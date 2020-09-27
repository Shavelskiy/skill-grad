<?php

namespace App\Controller;

use App\Dto\SearchQuery;
use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
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

    protected ArticleRepository $articleRepository;
    protected SessionInterface $session;

    public function __construct(
        ArticleRepository $articleRepository,
        SessionInterface $session
    ) {
        $this->articleRepository = $articleRepository;
        $this->session = $session;
    }

    /**
     * @Route("", name="blog.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $query = (new SearchQuery())
            ->setPage((int)($request->get('page', 1)))
            ->setPageItemCount(self::PAGE_ITEM_COUNT);

        $searchResult = $this->articleRepository->getPaginatorResult($query);

        $userArticles = [];

        /** @var User $user */
        if (($user = $this->getUser()) && $user->isProvider()) {
            $userArticles = $this->articleRepository->findUserArticles($user);
        }

        return $this->render('blog/index.html.twig', [
            'articles' => $searchResult->getItems(),
            'page' => $searchResult->getCurrentPage(),
            'total_pages' => $searchResult->getTotalPageCount(),
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

        return $this->render('blog/view.html.twig', [
            'article' => $article,
            'is_favorite' => $this->getUser() && $this->getUser()->getFavoriteArticles()->contains($article),
        ]);
    }
}
