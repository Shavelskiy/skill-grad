<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     *
     * @param UserInterface $user
     * @param string $newEncodedPassword
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param $token
     *
     * @return User
     */
    public function findByChatToken($token): User
    {
        try {
            if (empty($token)) {
                throw new RuntimeException('token is empty');
            }

            $user = $this->createQueryBuilder('u')
                ->where('u.chatToken = :chatToken')
                ->setParameter('chatToken', $token)
                ->getQuery()
                ->getResult();

            if (empty($user)) {
                throw new RuntimeException('user not found');
            }

            return current($user);
        } catch (Exception $e) {
            throw new NotFoundHttpException('Пользователь не найден');
        }
    }

    public function findByResetPasswordToken($token): User
    {
        try {
            if (empty($token)) {
                throw new RuntimeException('token is empty');
            }

            $user = $this->createQueryBuilder('u')
                ->where('u.resetPasswordToken = :resetPasswordToken')
                ->setParameter('resetPasswordToken', $token)
                ->getQuery()
                ->getResult();

            if (empty($user)) {
                throw new RuntimeException('user not found');
            }

            return current($user);
        } catch (Exception $e) {
            throw new NotFoundHttpException('Пользователь не найден');
        }
    }
}
