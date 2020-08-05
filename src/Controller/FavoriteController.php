<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    /**
     * @Route("/favorite", name="app.favorite", methods={"GET"})
     */
    public function favoriteAction(): Response
    {
        return $this->render('favorite/index.html.twig');
    }
}
