<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Dto\SearchQuery;
use App\Entity\Location;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @param $id
     * @return Location
     */
    public function findById($id): object
    {
        $location = $this->findOneBy(['id' => $id]);

        if ($location === null) {
            throw new NotFoundHttpException('location not found');
        }

        return $location;
    }

    /**
     * @param int $page
     * @param array|null $order
     * @param int $pageItems
     * @param array|null $serach
     * @return PaginatorResult
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
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
