<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    /**
     * @Route("/program", name="program.index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        return $this->render('program/index.html.twig');
    }

    /**
     * @Route("/program/{slug}", name="program.view", methods={"GET"})
     */
    public function actionView(): Response
    {
        return $this->render('program/view.html.twig');
    }

    /**
     * @Route("/program-create", name="program.add", methods={"GET"})
     */
    public function createAction(): Response
    {
//        @IsGranted("ROLE_PROVIDER")
        return $this->render('program/add.html.twig');
    }
}
