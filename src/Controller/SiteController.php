<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="site.index")
     */
    public function index(): Response
    {
        return $this->render('site/index.html.twig');
    }

    /**
     * @Route("/kek", name="site.kek")
     */
    public function kek(): Response
    {
        return $this->render('site/kek.html.twig');
    }
}
