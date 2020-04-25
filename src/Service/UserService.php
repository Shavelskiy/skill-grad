<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Throwable;

class UserService implements ResetUserPasswordInterface, RegisterUserInterface
{
    protected UserPasswordEncoderInterface $userPasswordEncoder;
    protected UserRepository $userRepository;
    protected EntityManagerInterface $em;
    protected AuthMailerInterface $authMailer;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder,
        EntityManagerInterface $em,
        AuthMailerInterface $authMailer
    )
    {
        $this->userRepository = $userRepository;
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

        $user->generateResetPasswordToken();

        $this->em->persist($user);
        $this->em->flush();

        $this->authMailer->sendResetPasswordEmail($user->getEmail(), $user->getResetPasswordToken()->getHex()->toString());
    }

    /**
     * @param string $token
     * @param string $newPassword
     */
    public function resetUserPassword(string $token, string $newPassword): void
    {
        /** @var User $user */
        $user = $this->userRepository ->findByResetPasswordToken($token);

        $user
            ->setPassword($this->userPasswordEncoder->encodePassword($user, $newPassword))
            ->resetResetPasswordToken();

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param string $email
     * @param string $password
     * @param bool $isProvider
     */
    public function registerUser(string $email, string $password, bool $isProvider): void
    {
        try {
            $user = $this->userRepository ->findUserByEmail($email);

            if ($user->isActive()) {
                throw new RuntimeException('Пользователь с такие E-mail уже зарегистрирован');
            }
        } catch (NotFoundHttpException $e) {
            $user = new User();
            $user->setEmail($email);
        } finally {
            $user->generateRegisterToken();
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $password));

            if ($isProvider) {
                $user->setRoles([User::ROLE_USER, User::ROLE_PROVIDER]);
            } else {
                $user->setRoles([User::ROLE_USER]);
            }
        }

        $this->em->persist($user);
        $this->em->flush();

        $this->authMailer->sendRegisterEmail($user->getEmail(), $user->getRegisterToken()->getHex()->toString());
    }

    /**
     * @param string $userEmail
     * @param string $socialKey
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
}
