<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/login")
     *
     * @return Response
     */
    public function login(): Response
    {
        return $this->render('admin/site/login.html.twig');
    }
}
