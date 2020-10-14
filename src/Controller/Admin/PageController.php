<?php

namespace App\Controller\Admin;

use App\Entity\Content\Faq;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("", name="admin.page.index", methods={"GET"})
     */
    public function index(Request $request): JsonResponse
    {

    }

    /**
     * @Route("/{faq}", name="admin.page.view", methods={"GET"}, requirements={"faq"="[0-9]+"})
     */
    public function view(Faq $faq): Response
    {

    }

    /**
     * @Route("", name="admin.page.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {

    }

    /**
     * @Route("", name="admin.page.update", methods={"PUT"})
     */
    public function update(Request $request): Response
    {

    }

    /**
     * @Route("", name="admin.page.delete", methods={"DELETE"})
     */
    public function delete(Request $request): Response
    {

    }
}
