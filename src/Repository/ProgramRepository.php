<?php

namespace App\Repository;

use App\Dto\Paginator;
use App\Entity\Program;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    public function getPaginatorUserItems(User $user, bool $active = true, int $page = 1, int $pageItems = 10): Paginator
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.active = :active')
            ->andWhere('p.user = :user')
            ->setParameters([
                'active' => $active,
                'user' => $user,
            ]);

        $programs = (clone $query)
            ->setFirstResult(($page - 1) * 10)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        $totalCount = (clone $query)
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return (new Paginator())
            ->setItems($programs)
            ->setCurrentPage($page)
            ->setTotalPageCount(ceil($totalCount / $pageItems));
    }
}
