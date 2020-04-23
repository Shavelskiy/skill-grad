<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService implements ResetUserPasswordInterface
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
}
