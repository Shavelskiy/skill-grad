<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\User;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
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

    public function findUserByEmail($email): User
    {
        try {
            $user = $this->createQueryBuilder('u')
                ->where('u.email = :email and u.socialKey is null')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult();

            if ($user !== null) {
                return $user;
            }
        } catch (Exception $e) {
        }

        throw new NotFoundHttpException('Пользователь с таким E-mail не найден');
    }

    public function findUserByEmailAndSocialKey($email, $socialKey): User
    {
        /** @var User|null $user */
        $user = $this->findOneBy(['email' => $email, 'socialKey' => $socialKey]);

        if ($user === null) {
            throw new NotFoundHttpException('user not found');
        }

        return $user;
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getPaginatorResult(SearchQuery $searchQuery): PaginatorResult
    {
        $query = $this
            ->createQueryBuilder('u')
            ->leftJoin('u.userInfo', 'ui');

        if ($searchQuery->getOrderField() !== null) {
            $query->addOrderBy('u.' . $searchQuery->getOrderField(), $searchQuery->getOrderType());
        }

        $query->addOrderBy('u.id', 'asc');

        foreach ($searchQuery->getSearch() as $field => $value) {
            switch ($field) {
                case 'id':
                    $query
                        ->andWhere('u.id = :id')
                        ->setParameter('id', (int)$value);
                    break;
                case 'fullName':
                    $query
                        ->andWhere('upper(ui.fullName) like :fullName')
                        ->setParameter('fullName', '%' . mb_strtoupper($value) . '%');
                    break;
                case 'email':
                    $query
                        ->andWhere('upper(u.email) like :email')
                        ->setParameter('name', '%' . mb_strtoupper($value) . '%');
                    break;
                case 'phone':
                    $query
                        ->andWhere('ui.phone like :phone')
                        ->setParameter('phone', "%$value%");
                    break;
                case 'active':
                    $query
                        ->andWhere('u.active = :active')
                        ->setParameter('active', $value);
                    break;
            }
        }

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($searchQuery->getPageItemCount())
            ->setPage($searchQuery->getPage())
            ->getResult();
    }
}
