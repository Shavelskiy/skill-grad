<?php

namespace App\Repository;

use App\Entity\Content\Faq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Faq|null find($id, $lockMode = null, $lockVersion = null)
 * @method Faq|null findOneBy(array $criteria, array $orderBy = null)
 * @method Faq[]    findAll()
 * @method Faq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faq::class);
    }

    /**
     * @return Faq[]
     */
    public function findActiveItems(): array
    {
        return $this
            ->createQueryBuilder('q')
            ->andWhere('q.active = :active')
            ->setParameter('active', true)
            ->orderBy('q.sort', 'asc')
            ->getQuery()
            ->getResult();
    }
}