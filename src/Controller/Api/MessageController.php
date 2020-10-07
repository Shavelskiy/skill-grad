<?php

namespace App\Controller\Api;

use App\Entity\ChatMessage;
use App\Entity\User;
use App\Repository\ChatMessageRepository;
use App\Repository\UserRepository;
use App\Service\User\UserInfoInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/message")
 */
class MessageController extends AbstractController
{
    protected ChatMessageRepository $chatMessageRepository;
    protected UserRepository $userRepository;
    protected UserInfoInterface $userService;

    public function __construct(
        ChatMessageRepository $chatMessageRepository,
        UserRepository $userRepository,
        UserInfoInterface $userService
    ) {
        $this->chatMessageRepository = $chatMessageRepository;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @Route("", name="api.message.index", methods={"GET"})
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $userIds = [];

        foreach ($this->chatMessageRepository->findMessageGroups($user) as $chatGroup) {
            if ($chatGroup['user_id'] !== $user->getId()) {
                $groupUserId = $chatGroup['user_id'];
            } else {
                $groupUserId = $chatGroup['recipient_id'];
            }

            if (!in_array($groupUserId, $userIds, true)) {
                $userIds[] = $groupUserId;
            }
        }

        $result = [];

        foreach ($userIds as $userId) {
            /** @var User $recipient */
            $recipient = $this->userRepository->find($userId);

            $lastMessage = $this->chatMessageRepository->findLastGroupMessage($user, $recipient);

            $recipient = ($lastMessage->getUser()->getId() !== $user->getId()) ? $lastMessage->getUser() : $lastMessage->getRecipient();

            $result[] = [
                'user' => [
                    'id' => $lastMessage->getUser()->getId(),
                    'name' => $this->userService->getUsername($lastMessage->getUser()),
                    'image' => $this->userService->getUserPhoto($lastMessage->getUser()),
                ],
                'recipient' => [
                    'id' => $recipient->getId(),
                    'name' => $this->userService->getUsername($recipient),
                    'image' => $this->userService->getUserPhoto($recipient),
                ],
                'message' => $lastMessage->jsonSerialize(),
                'new_count' => $this->chatMessageRepository->findNewMessageCount($user, $recipient),
            ];
        }

        return new JsonResponse([
            'groups' => $result,
        ]);
    }

    /**
     * @Route("/detail/{recipient}")
     */
    public function detailChat(User $recipient): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $messages = [];

        /** @var ChatMessage $chatMessage */
        foreach ($this->chatMessageRepository->findGroupMessages($user, $recipient) as $chatMessage) {
            $messages[] = $chatMessage->jsonSerialize();
        }

        return new JsonResponse([
            'user' => [
                'id' => $user->getId(),
                'name' => $this->userService->getUsername($user),
                'image' => $this->userService->getUserPhoto($user),
            ],
            'recipient' => [
                'id' => $recipient->getId(),
                'name' => $this->userService->getUsername($recipient),
                'image' => $this->userService->getUserPhoto($recipient),
            ],
            'messages' => $messages,
        ]);
    }
}
