<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserToken;
use App\Service\TokenService;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chat")
 */
class ChatController extends AbstractController
{
    protected TokenService $tokenService;

    public function __construct(
        TokenService $tokenService
    ) {
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/start", methods={"GET"})
     */
    public function getUserMessages(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user === null) {
            throw new RuntimeException('user is not exist');
        }

        $chatToken = $this->tokenService->generate($user, UserToken::TYPE_CHAT);

        return new JsonResponse([
            'token' => $chatToken->getToken()->getHex(),
        ]);
    }
}
