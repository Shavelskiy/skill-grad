<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\ParameterBag;

class CompareHelper
{
    public const COMPARE_PROGRAMS_KEY = 'compare_programs';

    public static function getCompareProgramsFromParameterBag(ParameterBag $parameterBag): array
    {
        return (array)json_decode($parameterBag->get(self::COMPARE_PROGRAMS_KEY));
    }
}
