<?php

namespace App\Cache;

use App\Entity\Article;
use App\Entity\Category;

final class Relations
{
    public const ENTITY = [
        Category::class => [
            Keys::HEADER_MENU,
        ],
        Article::class => [
            Keys::MAIN_BLOG,
        ],
    ];
}
