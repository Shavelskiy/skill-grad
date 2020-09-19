<?php

namespace App\Twig;

use App\Entity\User;
use App\Helpers\CompareHelper;
use App\Repository\ChatMessageRepository;
use Symfony\Component\HttpFoundation\ParameterBag;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CommonExtension extends AbstractExtension
{
    protected ChatMessageRepository $chatMessageRepository;

    public function __construct(
        ChatMessageRepository $chatMessageRepository
    ) {
        $this->chatMessageRepository = $chatMessageRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCompareCount', [$this, 'getCompareCount']),
            new TwigFunction('inCompare', [$this, 'inCompare']),
            new TwigFunction('getUsername', [$this, 'getUsername']),
            new TwigFunction('getNewMessagesCount', [$this, 'getNewMessagesCount']),
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

    public function getUsername(?User $user): string
    {
        if ($user === null) {
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

    public function getNewMessagesCount(User $user): int
    {
        return $this->chatMessageRepository->findNewMessageCount($user);
    }
}
