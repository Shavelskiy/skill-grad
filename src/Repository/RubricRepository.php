<?php

namespace App\Repository;

use App\Entity\Rubric;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;

/**
 * @method Rubric|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rubric|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rubric[]    findAll()
 * @method Rubric[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RubricRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rubric::class);
    }

    public function getRubricWithMaxSort(): ?Rubric
    {
        try {
            return $this->createQueryBuilder('r')
                ->orderBy('r.sort', 'desc')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (Exception $e) {
            return null;
        }
    }
}
