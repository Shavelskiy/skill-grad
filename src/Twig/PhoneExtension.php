<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhoneExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('format_phone', [$this, 'formatPhone']),
        ];
    }

    public function formatPhone($value): string
    {
        return '+' . substr($value, 0, 1) . ' (' . substr($value, 1, 3) . ') ' . substr($value, 4, 3) . '-' . substr($value, 7, 2) . '-' . substr($value, 9, 2);
    }
}