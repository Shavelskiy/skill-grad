<?php

namespace App\Repository;

use App\Entity\ChatMessage;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ChatMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatMessage::class);
    }

    public function findUserMessages(User $user): array
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.dateSend', 'asc')
            ->andWhere('c.recipient = :user')
            ->orWhere('c.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findMessageGroups(User $user): array
    {
        return $this
            ->createQueryBuilder('c')
            ->select('u.id as user_id, r.id as recipient_id')
            ->join('c.user', 'u')
            ->join('c.recipient', 'r')
            ->andWhere('c.recipient = :user')
            ->orWhere('c.user = :user')
            ->setParameter('user', $user)
            ->groupBy('u.id')
            ->addGroupBy('r.id')
            ->getQuery()
            ->getResult();
    }

    public function findGroupMessages(User $user, User $recipient): array
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.dateSend', 'asc')
            ->andWhere('c.recipient = :recipient AND c.user = :user')
            ->orWhere('c.recipient = :user AND c.user = :recipient')
            ->setParameters([
                'user' => $user,
                'recipient' => $recipient,
            ])
            ->getQuery()
            ->getResult();
    }

    public function findLastGroupMessage(User $user, User $recipient): ChatMessage
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.dateSend', 'desc')
            ->andWhere('c.recipient = :recipient AND c.user = :user')
            ->orWhere('c.recipient = :user AND c.user = :recipient')
            ->setParameters([
                'user' => $user,
                'recipient' => $recipient,
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findNewMessages(User $user, User $recipient): array
    {
        return $this
            ->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->andWhere('c.recipient = :recipient')
            ->andWhere('c.viewed = :viewed')
            ->setParameters([
                'user' => $user,
                'recipient' => $recipient,
                'viewed' => false,
            ])
            ->getQuery()
            ->getResult();
    }

    public function findNewMessageCount(User $recipient, ?User $user = null): int
    {
        $query = $this
            ->createQueryBuilder('c')
            ->select('count(c.id)')
            ->andWhere('c.recipient = :recipient')
            ->andWhere('c.viewed = :viewed')
            ->setParameters([
                'recipient' => $recipient,
                'viewed' => false,
            ]);

        if ($user !== null) {
            $query
                ->andWhere('c.user = :user')
                ->setParameter('user', $user);
        }

        return $query
            ->getQuery()
            ->getSingleScalarResult();
    }
}
