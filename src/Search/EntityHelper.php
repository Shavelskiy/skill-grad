<?php

namespace App\Search;

use App\Entity\Article;
use App\Entity\Program\Program;
use App\Entity\Provider;

class EntityHelper
{
    public static function articleToArray(Article $article): array
    {
        return [
            'name' => $article->getName(),
            'detailText' => $article->getDetailText(),
            'tags' => [],
        ];
    }

    public static function providerToArray(Provider $provider): array
    {
        return [
            'name' => $provider->getName(),
            'description' => $provider->getDescription(),
        ];
    }

    public static function programToArray(Program $program): array
    {
        return [
            'name' => $program->getName(),
            'description' => $program->getDetailText(),
            'locations' => $program->getLocations()->map(fn ($location) => $location->getId()),
            'min_price' => 0,
            'max_price' => 0,
            'level' => $program->getLevel()->getId(),
            'practice' => 32,
            'format' => $program->getFormat()->getId(),
            'rating' => 32,
            'categories' => $program->getCategories()->map(fn ($category) => $category->getId()),
        ];
    }
}
