<?php

namespace App\Enum\Cache;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Program\Program;

final class Relations
{
    public const ENTITY = [
        Category::class => [
            Keys::HEADER_MENU,
        ],
        Article::class => [
            Keys::MAIN_BLOG,
        ],
        Program::class => [
            Keys::MAIN_SLIDER,
        ],
        Location::class => [
            Keys::ALL_LOCATIONS,
            Keys::HEADER_LOCATIONS,
        ],
    ];
}
