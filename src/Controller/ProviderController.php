<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/provider")
 */
class ProviderController extends AbstractController
{
    /**
     * @Route("", name="provider.index", methods={"GET"})
     */
    public function actionIndex(): Response
    {
        return $this->render('provider/index.html.twig');
    }

    /**
     * @Route("/{slug}", name="provider.view", methods={"GET"})
     */
    public function actionView(): Response
    {
        return $this->render('provider/view.html.twig');
    }
}
