<?php

namespace App\Cache;

use App\Entity\Category;

final class Relations
{
    public const ENTITY = [
        Category::class => [
            Keys::HEADER_MENU
        ],
    ];
}
