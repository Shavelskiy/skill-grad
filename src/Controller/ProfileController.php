<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/{path}/", methods={"GET"}, requirements={"path"=".*"}, name="site.profile")
     */
    public function index(): Response
    {
        if ($this->isGranted(User::ROLE_PROVIDER)) {
            return $this->render('profile/provider.profile.html.twig');
        }

        return $this->render('profile/user.profile.html.twig');
    }
}
