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

}
