<?php

namespace App\Service\User;

use App\Dto\UpdateUserData;
use App\Entity\User;
use App\Entity\UserInfo;
use App\Entity\UserToken;
use App\Repository\UserRepository;
use App\Repository\UserTokenRepository;
use App\Service\AuthMailerInterface;
use App\Service\UploadServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService implements ResetUserPasswordInterface, RegisterUserInterface, UpdateUserInterface, UserInfoInterface
{
    protected UserPasswordEncoderInterface $userPasswordEncoder;
    protected UserRepository $userRepository;
    protected UserTokenRepository $userTokenRepository;
    protected EntityManagerInterface $entityManager;
    protected AuthMailerInterface $authMailer;
    protected UploadServiceInterface $uploadService;

    public function __construct(
        UserRepository $userRepository,
        UserTokenRepository $userTokenRepository,
        UserPasswordEncoderInterface $userPasswordEncoder,
        EntityManagerInterface $entityManager,
        AuthMailerInterface $authMailer,
        UploadServiceInterface $uploadService
    ) {
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
        $this->authMailer = $authMailer;
        $this->uploadService = $uploadService;
    }

    public function initResetUserPassword(string $email): void
    {
        $user = $this->userRepository->findUserByEmail($email);

        $token = (new UserToken(UserToken::TYPE_RESET_PASSWORD))->setUser($user);

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        $this->authMailer->sendResetPasswordEmail(
            $user->getEmail(),
            $token->getToken()->getHex()->toString()
        );
    }

    public function resetUserPassword(string $token, string $newPassword): void
    {
        $userToken = $this->userTokenRepository->findByTokenAndType($token, UserToken::TYPE_RESET_PASSWORD);

        $user = $userToken->getUser();
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $newPassword));

        $this->entityManager->persist($user);
        $this->entityManager->remove($userToken);
        $this->entityManager->flush();
    }

    public function registerUser(string $email, string $password, bool $isProvider): void
    {
        try {
            $user = $this->userRepository->findUserByEmail($email);

            if ($user->isActive()) {
                throw new RuntimeException('Пользователь с такие E-mail уже зарегистрирован');
            }
        } catch (NotFoundHttpException $e) {
            $user = new User();
            $user->setEmail($email);
        } finally {
            $registerToken = (new UserToken(UserToken::TYPE_REGISTER))->setUser($user);
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));

            if ($isProvider) {
                $user->setRoles([User::ROLE_USER, User::ROLE_PROVIDER]);
            } else {
                $user->setRoles([User::ROLE_USER]);
            }
        }

        $this->entityManager->persist($user);
        $this->entityManager->persist($registerToken);
        $this->entityManager->flush();

        $this->authMailer->sendRegisterEmail(
            $user->getEmail(),
            $registerToken->getToken()->getHex()->toString()
        );
    }

    public function createSocialUser(string $userEmail, string $socialKey): User
    {
        $user = (new User())
            ->setUsername($userEmail)
            ->setRoles([User::ROLE_USER])
            ->setActive(true)
            ->setSocialKey($socialKey);

        $user->setPassword(
            $this->userPasswordEncoder->encodePassword($user, '123456')
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function updateUser(User $user, UpdateUserData $updateUserData)
    {
        if (($userInfo = $user->getUserInfo()) === null) {
            $userInfo = (new UserInfo())
                ->setUser($user);

            $user->setUserInfo($userInfo);

            $this->entityManager->persist($userInfo);
        }

        if (!$user->isProvider()) {
            if ($userInfo->getImage() !== null && $updateUserData->getOldImage() === null) {
                $this->uploadService->deleteUpload($userInfo->getImage());
                $userInfo->setImage(null);
            }

            if ($updateUserData->getImage() !== null) {
                $upload = $this->uploadService->createUpload($updateUserData->getImage());
                $this->entityManager->persist($upload);
                $userInfo->setImage($upload);
            }

            $userInfo
                ->setDescription($updateUserData->getDescription())
                ->setCategory($updateUserData->getCategory());
        }

        $userInfo
            ->setFullName($updateUserData->getFullName())
            ->setPhone($updateUserData->getPhone());

        $emailUser = $this->userRepository->findOneBy(['email' => $updateUserData->getEmail()]);

        if ($emailUser !== null && $emailUser->getId() !== $user->getId()) {
            throw  new RuntimeException('Данный email уже занят');
        }

        $user
            ->setEmail($updateUserData->getEmail());

        if (!empty($updateUserData->getOldPassword())) {
            $this->checkPasswordCorrect($user, $updateUserData->getOldPassword());
            $this->updateUserPassword($user, $updateUserData->getNewPassword());
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    protected function checkPasswordCorrect(User $user, string $oldPassword): void
    {
        if (!$this->userPasswordEncoder->isPasswordValid($user, $oldPassword)) {
            throw new RuntimeException('Старый пароль неверный');
        }
    }

    protected function updateUserPassword(User $user, string $password)
    {
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));
    }

    public function getUsername(?User $user): string
    {
        if ($user === null) {
            return '';
        }

        if ($user->isProvider() && $user->getProvider() !== null) {
            return $user->getProvider()->getName();
        }

        if ($user->getUserInfo() === null) {
            return $user->getEmail();
        }

        $fullName = $user->getUserInfo()->getFullName();

        if ($fullName !== null && !empty($fullName)) {
            return $fullName;
        }

        return $user->getEmail();
    }

    public function getUserPhoto(?User $user): string
    {
        if ($user === null) {
            return '/upload/img/provider_no_logo.png';
        }

        if ($user->isProvider() && $user->getProvider() !== null) {
            return $user->getProvider()->getImage() ? $user->getProvider()->getImage()->getPublicPath() : '/upload/img/provider_no_logo.png';
        }

        if ($user->getUserInfo() === null) {
            return '/upload/img/provider_no_logo.png';
        }

        return $user->getUserInfo()->getImage() ? $user->getUserInfo()->getImage()->getPublicPath() : '/upload/img/provider_no_logo.png';
    }
}
