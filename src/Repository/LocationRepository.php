<?php

namespace App\Repository;

use App\Dto\Filter\LocationFilter;
use App\Dto\PaginatorResult;
use App\Entity\Location;
use App\Entity\Program;
use App\Entity\ProgramRequest;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    protected const ORDABLE_FIELDS = ['id', 'sort', 'type', 'name'];

    public function findById($id): Location
    {
        $location = $this->findOneBy(['id' => $id]);

        if ($location === null) {
            throw new NotFoundHttpException('location not found');
        }

        return $location;
    }

    /**
     * @param LocationFilter $locationFilter
     *
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
     * @param Program $program
     * @param int $page
     * @param int $pageItems
     * @return PaginatorResult
     */
    public function getPaginatorLocations(int $page, ?array $order, int $pageItems = 5): PaginatorResult
    {
        $query = $this->createQueryBuilder('l');

        if ($order !== null) {
            foreach ($order as $field => $order) {
                if (!in_array($field, self::ORDABLE_FIELDS, true)) {
                    continue;
                }

                if ($order === null || !in_array($order, ['asc', 'desc'], true)) {
                    continue;
                }

                $query->addOrderBy("l.$field", $order);
            }
        }

        $query
            ->addOrderBy('l.sort', 'asc')
            ->addOrderBy('l.id', 'asc');

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($pageItems)
            ->setPage($page)
            ->getResult();
    }
}
