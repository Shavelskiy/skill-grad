<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class SiteController extends AdminAbstractController
{
    /**
     * @Route("/{path}/", methods={"GET"}, requirements={"path"=".*"}, name="admin.index")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/login", name="admin.site.login")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->isGranted(User::ROLE_ADMIN) ||
            $this->isGranted(User::ROLE_REDACTOR) ||
            $this->isGranted(User::ROLE_SEO_MANAGER)
        ) {
            return $this->redirectToRoute('admin.site.index');
        }

        return $this->render('admin/site/login.html.twig', [
            'login' => $authenticationUtils->getLastUsername(),
        ]);
    }
}
