<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class SiteController extends AdminAbstractController
{
    /**
     * @Route("/", name="admin.site.index")
     */
    public function index(): Response
    {
        return $this->render('admin/site/index.html.twig');
    }

    /**
     * @Route("/login", name="admin.site.login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('admin.site.index');
        }

        return $this->render('admin/site/login.html.twig', [
            'login' => $authenticationUtils->getLastUsername()
        ]);
    }
}
