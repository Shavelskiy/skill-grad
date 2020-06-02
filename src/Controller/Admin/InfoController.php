<?php

namespace App\Controller\Admin;

use App\Entity\User;
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
        /** @var User $user */
        if ($user = $this->getUser()) {
            return new JsonResponse([
                'current_user' => [
                    'id' => $user->getId(),
                    'username' => $this->getUserUsername($user),
                ],
            ]);
        }

        return new JsonResponse([], 401);
    }

    protected function getUserUsername(User $user): string
    {
        $userInfo = $user->getUserInfo();
        if ($userInfo !== null && $userInfo->getFullName() !== null && !empty($userInfo->getFullName())) {
            return $userInfo->getFullName();
        }

        return  $user->getUsername();
    }
}
