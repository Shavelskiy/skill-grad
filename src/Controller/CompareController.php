<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompareController extends AbstractController
{
    /**
     * @Route("/compare", name="app.compare", methods={"GET"})
     */
    public function compareAction(): Response
    {
        return $this->render('compare/index.html.twig');
    }
}
