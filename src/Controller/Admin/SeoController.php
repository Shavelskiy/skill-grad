<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/seo")
 */
class SeoController extends AbstractController
{
    /**
     * @Route("", name="admin.seo.index", methods={"GET"})
     */
    public function index(): Response
    {

    }

    /**
     * @Route("/article", name="admin.seo.index", methods={"GET"})
     */
    public function articleIndex(): Response
    {

    }

    /**
     * @Route("/provider", name="admin.seo.index", methods={"GET"})
     */
    public function providerIndex(): Response
    {

    }

    /**
     * @Route("/program", name="admin.seo.index", methods={"GET"})
     */
    public function programIndex(): Response
    {

    }

    /**
     * @Route("/page", name="admin.seo.index", methods={"GET"})
     */
    public function pageIndex(): Response
    {
    }
}
