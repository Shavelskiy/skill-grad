<?php

namespace App\Controller\Ajax;

use App\Entity\ArticleComment;
use App\Repository\ArticleCommentRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax/blog/comment")
 */
class BlogCommentController extends AbstractController
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
     * @Route("", name="ajax.blog.comment.add", methods={"POST"})
     */
    public function add(Request $request): Response
    {
        $comment = (new ArticleComment())
            ->setUser($this->getUser())
            ->setText($request->get('text'));

        if ($request->request->has('parent_comment_id')) {
            $parentComment = $this->articleCommentRepository->find($request->get('parent_comment_id'));

            if ($parentComment === null) {
                return new JsonResponse([], 404);
            }

            $comment
                ->setArticle($parentComment->getArticle())
                ->setParentComment($parentComment);
        } else {
            $article = $this->articleRepository->find($request->get('id'));

            if ($article === null) {
                return new JsonResponse([], 404);
            }

            $comment->setArticle($article);
        }

        $this->entityManger->persist($comment);
        $this->entityManger->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/{articleComment}", name="ajax.blog.comment.edit", methods={"PUT"})
     */
    public function edit(ArticleComment $articleComment, Request $request): Response
    {
        if ($this->getUser()->getId() !== $articleComment->getUser()->getId()) {
            return new JsonResponse([], 403);
        }

        $articleComment->setText($request->get('text'));

        $this->entityManger->persist($articleComment);
        $this->entityManger->flush();

        return new JsonResponse();
    }

    /**
     * @Route("/{articleComment}", name="ajax.blog.comment.delelte", methods={"DELETE"})
     */
    public function delete(ArticleComment $articleComment): Response
    {
        if ($this->getUser()->getId() !== $articleComment->getUser()->getId()) {
            return new JsonResponse([], 403);
        }

        $this->entityManger->remove($articleComment);
        $this->entityManger->flush();

        return new JsonResponse();
    }
}
