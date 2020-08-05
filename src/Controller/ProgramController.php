<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/program")
 */
class ProgramController extends AbstractController
{
    /**
     * @Route("", name="program.index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        return $this->render('program/index.html.twig');
    }

    /**
     * @Route("/{slug}", name="program.view", methods={"GET"})
     */
    public function actionView(): Response
    {
        return $this->render('program/view.html.twig');
    }

    /**
     * @Route("/add", name="program.add", methods={"GET"})
     *
     * @IsGranted("ROLE_PROVIDER")
     */
    public function addAction(): Response
    {
        return $this->render('program/add.html.twig');
    }
}
