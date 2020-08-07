<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends AbstractController
{
    /**
     * @Route("/faq", name="faq.index", methods={"GET"})
     */
    public function actionIndex(): Response
    {
        return $this->render('static/faq.html.twig');
    }

    /**
     * @Route("/faq/student", name="faq.student", methods={"GET"})
     */
    public function studentAction(): Response
    {
        return $this->render('static/student-faq.html.twig');
    }

    /**
     * @Route("/faq/provider", name="faq.provider", methods={"GET"})
     */
    public function providerAction(): Response
    {
        return $this->render('static/provider-faq.html.twig');

    }

    /**
     * @Route("/compare", name="app.compare", methods={"GET"})
     */
    public function compareAction(): Response
    {
        return $this->render('static/compare.html.twig');
    }

    /**
     * @Route("/favorite", name="app.favorite", methods={"GET"})
     */
    public function favoriteAction(): Response
    {
        return $this->render('static/favorite.html.twig');
    }
}
