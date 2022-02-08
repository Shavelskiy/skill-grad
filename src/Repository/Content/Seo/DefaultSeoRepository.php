<?php

namespace App\Repository\Content\Seo;

use App\Entity\Content\Seo\DefaultSeo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DefaultSeo|null find($id, $lockMode = null, $lockVersion = null)
 * @method DefaultSeo|null findOneBy(array $criteria, array $orderBy = null)
 * @method DefaultSeo[]    findAll()
 * @method DefaultSeo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefaultSeoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DefaultSeo::class);
    }
}
