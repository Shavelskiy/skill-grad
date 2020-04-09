<?php

namespace App\Controller\Ajax;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="ajax.auth.login")
     */
    public function login(): Response
    {
        return $this->redirectToRoute('site.index');
    }

    /**
     * @Route("/logout", name="ajax.auth.logout")
     */
    public function logout(): void
    {
        throw new LogicException('Метод должен быть для того, чтобы было имя и middleware смог перехватить его');
    }
}
