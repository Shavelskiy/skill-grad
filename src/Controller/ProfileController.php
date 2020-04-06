<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/{path}", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }
}
