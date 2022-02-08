<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserToken;
use App\Repository\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class TokenService
{
    protected EntityManagerInterface $entityManager;
    protected UserTokenRepository $userTokenRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserTokenRepository $userTokenRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userTokenRepository = $userTokenRepository;
    }

    public function generate(User $user, string $type): UserToken
    {
        try {
            $chatToken = $this->userTokenRepository->findByUserAndType($user, $type);
        } catch (Exception $e) {
            $chatToken = (new UserToken($type))->setUser($user);

            $this->entityManager->persist($chatToken);
            $this->entityManager->flush();
        }

        return $chatToken;
    }
}
