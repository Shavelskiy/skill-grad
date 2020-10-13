<?php

namespace App\Controller\Ajax;

use App\Entity\User;
use App\Entity\UserToken;
use App\Repository\ChatMessageRepository;
use App\Service\TokenService;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ajax/message")
 */
class MessageController extends AbstractController
{
    protected ChatMessageRepository $chatMessageRepository;
    protected TokenService $tokenService;

    public function __construct(
        ChatMessageRepository $chatMessageRepository,
        TokenService $tokenService
    ) {
        $this->chatMessageRepository = $chatMessageRepository;
        $this->tokenService = $tokenService;
    }

    /**
     * @Route("/start", methods={"GET"})
     */
    public function getUserMessages(): JsonResponse
    {
        if (($user = $this->getUser()) === null) {
            throw new RuntimeException('user is not exist');
        }

        $chatToken = $this->tokenService->generate($user, UserToken::TYPE_CHAT);

        return new JsonResponse([
            'token' => $chatToken->getToken()->getHex(),
        ]);
    }

    /**
     * @Route("/new", name="ajax.message.new", methods={"GET"})
     */
    public function newCount(): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            throw $this->createNotFoundException();
        }

        return new JsonResponse(['count' => $this->chatMessageRepository->findNewMessageCount($user)]);
    }
}
