<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/{slug}", name="blog.view")
     */
    public function view(Request $request): Response
    {
        return $this->render('blog/index.html.twig', [
            'slug' => $request->get('slug'),
        ]);
    }
}
