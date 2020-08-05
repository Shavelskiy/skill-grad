<?php

namespace App\Controller;

use App\Entity\Article;
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
    public function indexAction(): Response
    {
        return $this->render('blog/index.html.twig');
    }

    /**
     * @Route("/{slug}", name="blog.view", methods={"GET"})
     */
    public function viewAction(Request $request): Response
    {
        /** @var Article[] $articles */
//        $articles = $this->articleRepository->findBy(['slug' => $request->get('slug')]);
//        $article = current($articles);
//
//        $userViewsArticle = $this->session->get('article.view', []);
//
//        if (!in_array($article->getId(), $userViewsArticle, true)) {
//            $article->setViews($article->getViews() + 1);
//            $this->getDoctrine()->getManager()->persist($article);
//            $this->getDoctrine()->getManager()->flush();
//
//            $userViewsArticle[] = $article->getId();
//            $this->session->set('article.view', $userViewsArticle);
//        }

        return $this->render('blog/view.html.twig', [
//            'slug' => $request->get('slug'),
//            'views' => $article->getViews(),
        ]);
    }
}
