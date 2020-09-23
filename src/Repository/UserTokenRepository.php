<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method UserToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserToken[]    findAll()
 * @method UserToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    public function findByTokenAndType($token, string $type): UserToken
    {
        try {
            if (empty($token)) {
                throw new RuntimeException('token is empty');
            }

            $token = $this->createQueryBuilder('u')
                ->andWhere('u.token = :token')
                ->andWhere('u.type = :type')
                ->setParameters([
                    'token' => $token,
                    'type' => $type,
                ])
                ->getQuery()
                ->getResult();

            if (empty($token)) {
                throw new RuntimeException('user not found');
            }

            return current($token);
        } catch (Exception $e) {
            throw new NotFoundHttpException('Пользователь не найден');
        }
    }

    public function findByUserAndType(User $user, string $type): UserToken
    {
        try {
            $token = $this->createQueryBuilder('u')
                ->andWhere('u.user = :user')
                ->andWhere('u.type = :type')
                ->setParameters([
                    'user' => $user,
                    'type' => $type,
                ])
                ->getQuery()
                ->getResult();

            if (empty($token)) {
                throw new RuntimeException('user not found');
            }

            return current($token);
        } catch (Exception $e) {
            throw new NotFoundHttpException('Пользователь не найден');
        }
    }
}
