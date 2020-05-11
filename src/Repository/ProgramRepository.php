<?php

namespace App\Repository;

use App\Dto\PaginatorResult;
use App\Entity\Program;
use App\Entity\User;
use App\Helpers\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    public function getPaginatorUserItems(User $user, bool $active = true, int $page = 1, int $pageItems = 10): PaginatorResult
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.active = :active')
            ->andWhere('p.user = :user')
            ->setParameters([
                'active' => $active,
                'user' => $user,
            ]);

        return (new Paginator())
            ->setQuery($query)
            ->setPage($page)
            ->getResult();
    }
}
