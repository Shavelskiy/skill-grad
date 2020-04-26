<?php

namespace App\Repository;

use App\Dto\Filter\LocationFilter;
use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @param LocationFilter $locationFilter
     * @return QueryBuilder
     */
    public function getQueryFromFilter(LocationFilter $locationFilter): QueryBuilder
    {
        $query = $this->createQueryBuilder('location');

        if ($locationFilter->getId() !== null) {
            $query
                ->andWhere('location.id = :id')
                ->setParameter('id', $locationFilter->getId());
        }

        if ($locationFilter->getName() !== null) {
            $query
                ->andWhere('lower(location.name) like :name')
                ->setParameter('name', '%' . strtolower($locationFilter->getName()) . '%');
        }

        if ($locationFilter->getType() !== null) {
            $query
                ->andWhere('location.type = :type')
                ->setParameter('type', $locationFilter->getType());
        }

        return $query;
    }

    /**
     * @param QueryBuilder $query
     * @return int
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getCountFromQuery(QueryBuilder $query): int
    {
        return ((clone $query)
            ->select('COUNT(location.id)')
            ->getQuery()
            ->getSingleScalarResult());
    }
}
