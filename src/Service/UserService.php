<?php

namespace App\Service;

use App\Dto\UpdateUserData;
use App\Entity\User;
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
    protected EntityManagerInterface $em;
    protected AuthMailerInterface $authMailer;

    public function __construct(
        UserRepository $userRepository,
        UserTokenRepository $userTokenRepository,
        UserPasswordEncoderInterface $userPasswordEncoder,
        EntityManagerInterface $em,
        AuthMailerInterface $authMailer
    ) {
        $this->userRepository = $userRepository;
        $this->userTokenRepository = $userTokenRepository;
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->em = $em;
        $this->authMailer = $authMailer;
    }

    /**
     * @param string $email
     */
    public function initResetUserPassword(string $email): void
    {
        /** @var User $user */
        $user = $this->userRepository->findUserByEmail($email);

        $token = (new UserToken(UserToken::TYPE_RESET_PASSWORD))->setUser($user);

        $this->em->persist($token);
        $this->em->flush();

        $this->authMailer->sendResetPasswordEmail(
            $user->getEmail(), 
            $token->getToken()->getHex()->toString()
        );
    }

    /**
     * @param string $token
     * @param string $newPassword
     */
    public function resetUserPassword(string $token, string $newPassword): void
    {
        $userToken = $this->userTokenRepository->findByTokenAndType($token, UserToken::TYPE_RESET_PASSWORD);

        $user = $userToken->getUser();
        $user->setPassword($this->userPasswordEncoder->encodePassword($user, $newPassword));

        $this->em->persist($user);
        $this->em->remove($userToken);
        $this->em->flush();
    }

    /**
     * @param string $email
     * @param string $password
     * @param bool   $isProvider
     */
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

        $this->em->persist($user);
        $this->em->persist($registerToken);
        $this->em->flush();

        $this->authMailer->sendRegisterEmail(
            $user->getEmail(),
            $registerToken->getToken()->getHex()->toString()
        );
    }

    /**
     * @param string $userEmail
     * @param string $socialKey
     *
     * @return User
     */
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

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param User           $user
     * @param UpdateUserData $updateUserData
     */
    public function updateUser(User $user, UpdateUserData $updateUserData)
    {
        $user
//            ->setFullName($updateUserData->getFullName())
            ->setEmail($updateUserData->getEmail())
            ->setPhone($updateUserData->getPhone());

        if (!empty($updateUserData->getOldPassword())) {
            $this->checkPasswordCorrect($user, $updateUserData->getOldPassword());
            $this->updateUserPassword($user, $updateUserData->getNewPassword());
        }

        $this->em->persist($user);
        $this->em->flush();
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
