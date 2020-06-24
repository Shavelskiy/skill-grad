<?php

namespace App\Repository;

use App\Entity\UserToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    /**
     * @param $token
     */
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
}
