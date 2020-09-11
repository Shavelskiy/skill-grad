<?php

namespace App\Twig;

use App\Helpers\CompareHelper;
use Symfony\Component\HttpFoundation\ParameterBag;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CommonExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getCompareCount', [$this, 'getCompareCount']),
        ];
    }

    public function getCompareCount(ParameterBag $cookies): int
    {
        return count(CompareHelper::getCompareProgramsFromParameterBag($cookies));
    }
}
