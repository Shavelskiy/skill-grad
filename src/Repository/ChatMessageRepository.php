<?php

namespace App\Repository;

use App\Entity\ChatMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ChatMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatMessage::class);
    }

    public function findUserMessages($user)
    {
        return $this->createQueryBuilder('chat_message')
            ->orderBy('chat_message.dateSend', 'desc')
            ->andWhere('chat_message.recipient = :user')
            ->orWhere('chat_message.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
