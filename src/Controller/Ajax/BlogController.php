<?php

namespace App\Controller\Ajax;

use App\Entity\ArticleComment;
use App\Entity\ArticleRating;
use App\Entity\User;
use App\Repository\ArticleCommentRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax/blog")
 */
class BlogController extends AbstractController
{
    protected EntityManagerInterface $entityManger;
    protected ArticleRepository $articleRepository;
    protected ArticleCommentRepository $articleCommentRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ArticleRepository $articleRepository,
        ArticleCommentRepository $articleCommentRepository
    ) {
        $this->entityManger = $entityManager;
        $this->articleRepository = $articleRepository;
        $this->articleCommentRepository = $articleCommentRepository;
    }

    /**
     * @Route("/like", name="ajax.blog.like", methods={"POST"})
     */
    public function like(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $article = $this->articleRepository->find($request->get('id'));
        $setLike = $request->get('action') === 'like';

        if ($article === null) {
            return new JsonResponse([], 404);
        }

        /** @var ArticleRating $rating */
        foreach ($article->getRatings() as $rating) {
            if ($rating->getUser()->getId() === $user->getId()) {
                $articleRating = $rating;

                if ($articleRating->isLike() === $setLike) {
                    $this->entityManger->remove($articleRating);
                } else {
                    $articleRating->setLike($setLike);
                    $this->entityManger->persist($articleRating);
                }

                $this->entityManger->flush();

                return new JsonResponse();
            }
        }

        $articleRating = (new ArticleRating())
            ->setArticle($article)
            ->setUser($user)
            ->setLike($setLike);

        $this->entityManger->persist($articleRating);
        $this->entityManger->flush();

        return new JsonResponse();
    }
}
