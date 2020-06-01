<?php

namespace App\Repository;

use App\Dto\Filter\LocationFilter;
use App\Dto\PaginatorResult;
use App\Entity\Location;
use App\Entity\Program;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
    public function getPaginatorLocations(int $page, ?array $order, int $pageItems, ?array $serach): PaginatorResult
    {
        $query = $this->createQueryBuilder('l');

        if (!empty($order)) {
            $orderField = array_key_first($order);

            if (in_array($orderField, self::ORDABLE_FIELDS, true)) {
                $orderType = $order[$orderField];

                $query->addOrderBy("l.$orderField", ($orderType === 'asc') ? 'asc' : 'desc');
            }
        }

        if (!empty($serach)) {
            foreach ($serach as $field => $value) {
                switch ($field) {
                    case 'id':
                        $query
                            ->andWhere('l.id = :id')
                            ->setParameter('id', (int)$value);
                        break;
                    case 'name':
                        if (empty($value)) {
                            continue;
                        }
                        $query
                            ->andWhere('upper(l.name) like :name')
                            ->setParameter('name', '%' . mb_strtoupper($value) . '%');
                        break;
                    case 'type':
                        if (empty($value) || !in_array($value, Location::TYPES, true)) {
                            continue;
                        }
                        $query
                            ->andWhere('l.type = :type')
                            ->setParameter('type', $value);
                        break;
                    case 'sort':
                        $query
                            ->andWhere('l.sort = :sort')
                            ->setParameter('sort', (int)$value);
                        break;
                }
            }
        }

        $query
            ->addOrderBy('l.id', 'asc')
            ->addOrderBy('l.sort', 'asc');

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($pageItems)
            ->setPage($page)
            ->getResult();
    }
}
