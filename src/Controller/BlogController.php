<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Service\SearchService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends BaseCatalogRepository
{
    protected const PAGE_ITEM_COUNT = 10;
    protected const POPULAR_COMMENTS_COUNT = 5;

    protected ArticleRepository $articleRepository;
    protected UserRepository $userRepository;
    protected SessionInterface $session;

    public function __construct(
        SearchService $searchService,
        ArticleRepository $articleRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        SessionInterface $session
    ) {
        $this->searchService = $searchService;
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->session = $session;
    }

    /**
     * @Route("", name="blog.index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $page = $this->getPageFromRequest($request);

        $searchResult = $this->getArticleSearchResult($request, $page);

        $userArticles = [];

        /** @var User $user */
        if (($user = $this->getUser()) && $user->isProvider()) {
            $userArticles = $this->articleRepository->findUserArticles($user);
        }

        $popularAuthors = [];

        foreach ($this->articleRepository->findPopularAuthors() as $data) {
            $popularAuthors[$data['id']] = [
                'user' => null,
                'total_ratings' => $data['total_count'],
            ];
        }

        foreach ($this->userRepository->findBy(['id' => array_keys($popularAuthors)]) as $user) {
            $popularAuthors[$user->getId()]['user'] = $user;
        }

        return $this->render('blog/index.html.twig', [
            'articles' => $this->articleRepository->findBy(['id' => $searchResult['ids']]),
            'page' => $page,
            'total_pages' => $searchResult['total_pages'],
            'user_articles' => $userArticles,
            'popular_authors' => $popularAuthors,
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
            'popular_comment_ids' => $this->getPopularCommentIds($article),
        ]);
    }

    protected function getPopularCommentIds(Article $article): array
    {
        $result = [];

        for ($i = 1; $i < self::POPULAR_COMMENTS_COUNT; $i++) {
            $maxCommentId = null;
            $maxCommentAnswersCount = null;

            /** @var ArticleComment $comment */
            foreach ($article->getRootComments() as $comment) {
                if (in_array($comment->getId(), $result, true)) {
                    continue;
                }

                if ($maxCommentAnswersCount === null || $comment->getAnswers()->count() > $maxCommentAnswersCount) {
                    $maxCommentId = $comment->getId();
                    $maxCommentAnswersCount = $comment->getAnswers()->count();
                }
            }

            if ($maxCommentId === null) {
                break;
            }

            $result[] = $maxCommentId;
        }

        return $result;
    }
}
