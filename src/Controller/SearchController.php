<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app.search", methods={"GET"})
     */
    public function actionIndex(): Response
    {
        return $this->render('search/index.html.twig');
    }
}
