<?php

namespace App\Twig;

use App\Entity\User;
use App\Helpers\CompareHelper;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CommonExtension extends AbstractExtension
{
    protected TokenStorageInterface $tokenStorage;

    public function __construct(
        TokenStorageInterface $tokenStorage
    ) {
        $this->tokenStorage = $tokenStorage;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCompareCount', [$this, 'getCompareCount']),
            new TwigFunction('inCompare', [$this, 'inCompare']),
            new TwigFunction('getUsername', [$this, 'getUsername']),
        ];
    }

    public function getCompareCount(ParameterBag $cookies): int
    {
        return count(CompareHelper::getCompareProgramsFromParameterBag($cookies));
    }

    public function inCompare(int $programId, ParameterBag $cookies): bool
    {
        return in_array($programId, CompareHelper::getCompareProgramsFromParameterBag($cookies), true);
    }

    public function getUsername(): string
    {
        if (($token = $this->tokenStorage->getToken()) === null) {
            return '';
        }

        /** @var User $user */
        if (($user = $token->getUser()) === null) {
            return '';
        }

        if ($user->getUserInfo() === null) {
            return $user->getEmail();
        }

        $fullName = $user->getUserInfo()->getFullName();

        if ($fullName !== null && !empty($fullName)) {
            return $fullName;
        }

        return $user->getEmail();
    }
}
