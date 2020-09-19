<?php

namespace App\Controller\Ajax;

use App\Entity\User;
use App\Repository\ChatMessageRepository;
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

    public function __construct(
        ChatMessageRepository $chatMessageRepository
    ) {
        $this->chatMessageRepository = $chatMessageRepository;
    }

    /**
     * @Route("/new", name="ajax.message.new", methods={"GET"})
     */
    public function newCountAction(): Response
    {
        /** @var User $user */
        if (($user = $this->getUser()) === null) {
            throw $this->createNotFoundException();
        }

        return new JsonResponse(['count' => $this->chatMessageRepository->findNewMessageCount($user)]);
    }
}
