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
     * @Route("/add", name="program.add", methods={"GET"})
     *
     * @IsGranted("ROLE_PROVIDER")
     */
    public function add(): Response
    {
        return $this->render('program/add.html.twig');
    }
}
