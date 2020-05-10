<?php

namespace App\Controller\Api;

use App\Dto\UpdateUserData;
use App\Entity\User;
use App\Service\UpdateUserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/profile/settings")
 */
class ProfileSettingsController extends AbstractController
{
    protected UpdateUserInterface $updateUserService;
    protected ValidatorInterface $validator;

    public function __construct(
        UpdateUserInterface $updateUserService,
        ValidatorInterface $validator
    ) {
        $this->updateUserService = $updateUserService;
        $this->validator = $validator;
    }

    /**
     * @Route("/", methods={"GET"}, name="get.profile.settings")
     *
     * @return Response
     */
    public function getProfileSettings(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return new JsonResponse([
            'fullName' => $user->getFullName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
        ]);
    }

    /**
     * @Route("/", methods={"POST"}, name="save.profile.settings")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function saveProfileSettings(Request $request): Response
    {
        $updateUserData = (new UpdateUserData())
            ->setFullName($request->get('fullName'))
            ->setEmail($request->get('email'))
            ->setPhone($request->get('phone'))
            ->setOldPassword($request->get('oldPassword'))
            ->setNewPassword($request->get('newPassword'))
            ->setConfirmNewPassword($request->get('confirmNewPassword'));

        $errors = $this->validator->validate($updateUserData);

        /** @var User $user */
        $user = $this->getUser();

        $this->updateUserService->updateUser($user, $updateUserData);

        return new JsonResponse([
            'fullName' => $user->getFullName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
        ]);
    }
}
