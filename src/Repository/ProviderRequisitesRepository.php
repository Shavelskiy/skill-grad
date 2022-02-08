<?php

namespace App\Repository;

use App\Entity\Provider;
use App\Entity\ProviderRequisites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method ProviderRequisites|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProviderRequisites|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProviderRequisites[]    findAll()
 * @method ProviderRequisites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProviderRequisitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProviderRequisites::class);
    }

    public function findProviderRequisitesByProvider(Provider $provider): ?ProviderRequisites
    {
        try {
            return $this->createQueryBuilder('p')
                ->andWhere('p.provider = :provider')
                ->setParameter('provider', $provider)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (Exception $e) {
            return null;
        }
    }
}
