<?php

namespace App\Service;

use App\Dto\UpdateUserData;
use App\Entity\User;
use App\Entity\UserInfo;
use App\Entity\UserToken;
use App\Repository\UserRepository;
use App\Repository\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService implements ResetUserPasswordInterface, RegisterUserInterface, UpdateUserInterface
{
    protected UserPasswordEncoderInterface $userPasswordEncoder;
    protected UserRepository $userRepository;
    protected UserTokenRepository $userTokenRepository;
    protected EntityManagerInterface $entityManager;
    protected AuthMailerInterface $authMailer;

    public function __construct(
        UserRepository $userRepository,
        UserTokenRepository $userTokenRepository,
        UserPasswordEncoderInterface $userPasswordEncoder,
        EntityManagerInterface $entityManager,
        AuthMailerInterface $authMailer
    ) {
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
        $this->authMailer = $authMailer;
    }

    public function initResetUserPassword(string $email): void
    {
        /** @var User $user */
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

        $userInfo
            ->setFullName($updateUserData->getFullName())
            ->setPhone($updateUserData->getPhone())
            ->setDescription($updateUserData->getDescription())
            ->setCategory($updateUserData->getCategory());

        /** @var User $emailUser */
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
}
