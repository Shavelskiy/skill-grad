<?php

namespace App\Controller;

use App\Entity\ChatMessage;
use App\Entity\User;
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

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $chatMessageRepository = $this->getDoctrine()->getRepository(ChatMessage::class);

        $users = [];
        foreach ($userRepository->findAll() as $chatUser) {
            if ($user->getId() === $chatUser->getId()) {
                continue;
            }

            $users[] = [
                'id' => $chatUser->getId(),
                'username' => $chatUser->getUsername(),
            ];
        }

        $messages = [];
        /** @var ChatMessage $chatMessage */
        foreach ($chatMessageRepository->findUserMessages($user) as $chatMessage) {
            if ($chatMessage->getUser()->getId() === $user->getId()) {
                $messageUserId = $chatMessage->getRecipient()->getId();
            } else {
                $messageUserId = $chatMessage->getUser()->getId();
            }

            if (!isset($messages[$messageUserId])) {
                $messages[$messageUserId] = [];
            }

            $messages[$messageUserId][] =  [
                'id' => $chatMessage->getId(),
                'message' => $chatMessage->getMessage(),
                'dateSend' => $chatMessage->getDateSend()->format('d.m.Y h:m:s'),
                'senderUsername' => $chatMessage->getUser()->getUsername(),
                'viewed' => $chatMessage->isViewed(),
            ];
        }

        return new JsonResponse([
            'token' => $token->getHex(),
            'users' => $users,
            'messages' => $messages,
        ]);
    }
}
