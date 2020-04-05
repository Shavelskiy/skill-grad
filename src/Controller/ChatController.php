<?php

namespace App\Controller;

use Ramsey\Uuid\UuidInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chat")
 */
class ChatController extends AbstractController
{
    /**
     * @Route("/start", methods={"GET"})
     * @return JsonResponse
     */
    public function getUserMessages(): JsonResponse
    {
        $user = $this->getUser();

        if ($user === null) {
            throw new RuntimeException('user is not exist');
        }

        $user->generateChatToken();

        /** @var UuidInterface $token */
        $token = $user->getChatToken();

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'token' => $token->getHex(),
        ]);
    }
}
