<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/login")
 */
class LoginController extends AbstractController
{
    /**
     * @Route("", name="admin.login", methods={"POST", "GET"})
     */
    public function login(): Response
    {
        return new JsonResponse([], 404);
    }
}
