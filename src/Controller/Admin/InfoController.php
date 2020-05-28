<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/admin/info")
 */
class InfoController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="admin.info")
     */
    public function start(): Response
    {
        if ($user = $this->getUser()) {
            return new JsonResponse([
                'current_user' => [
                    'id' => $user->getId(),
                    'username' => !empty($user->getFullName()) ? $user->getFullName() : $user->getUsername(),
                ],
            ]);
        }

        return new JsonResponse([], 401);
    }
}
