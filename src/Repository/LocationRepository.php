<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Location;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function findById($id): object
    {
        $location = $this->findOneBy(['id' => $id]);

        if ($location === null) {
            throw new NotFoundHttpException('location not found');
        }

        return $location;
    }

    public function findAllCountries(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.type = :type')
            ->setParameter('type', Location::TYPE_COUNTRY)
            ->orderBy('l.sort', 'asc')
            ->addOrderBy('l.name', 'asc')
            ->getQuery()
            ->getResult();
    }

    public function findAllRegions(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.type = :type')
            ->setParameter('type', Location::TYPE_REGION)
            ->orderBy('l.sort', 'asc')
            ->addOrderBy('l.name', 'asc')
            ->getQuery()
            ->getResult();
    }

    public function findRegionCities(Location $region): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.parentLocation = :region')
            ->setParameter('region', $region)
            ->orderBy('l.sort', 'asc')
            ->addOrderBy('l.name', 'asc')
            ->getQuery()
            ->getResult();
    }

    public function findCityForList(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.type = :type')
            ->setParameter('type', Location::TYPE_CITY)
            ->andWhere('l.showInList = true')
            ->orderBy('l.sort', 'asc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getPaginatorResult(SearchQuery $searchQuery): PaginatorResult
    {
        $query = $this->createQueryBuilder('l');

        if ($searchQuery->getOrderField() !== null) {
            $query->addOrderBy('l.' . $searchQuery->getOrderField(), $searchQuery->getOrderType());
        }

        $query
            ->addOrderBy('l.id', 'asc')
            ->addOrderBy('l.sort', 'asc');

        foreach ($searchQuery->getSearch() as $field => $value) {
            switch ($field) {
                case 'id':
                    $query
                        ->andWhere('l.id = :id')
                        ->setParameter('id', (int)$value);
                    break;
                case 'name':
                    $query
                        ->andWhere('upper(l.name) like :name')
                        ->setParameter('name', '%' . mb_strtoupper($value) . '%');
                    break;
                case 'type':
                    if (!in_array($value, Location::TYPES, true)) {
                        continue 2;
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

        return (new Paginator())
            ->setQuery($query)
            ->setPageItems($searchQuery->getPageItemCount())
            ->setPage($searchQuery->getPage())
            ->getResult();
    }
}
