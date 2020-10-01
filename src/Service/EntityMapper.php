<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Program\Program;
use App\Entity\Provider;
use App\Service\ProgramService;

class EntityMapper
{
    protected ProgramService $programService;

    public function __construct(
        ProgramService $programService
    ) {
        $this->programService = $programService;
    }

    public function articleToArray(Article $article): array
    {
        return [
            'name' => $article->getName(),
            'previewText' => $article->getPreviewText(),
            'detailText' => $article->getDetailText(),
            'category' => $article->getCategory()->getId(),
        ];
    }

    public function providerToArray(Provider $provider): array
    {
        $categories = [];

        /** @var Category $category */
        foreach ($provider->getCategories() as $category) {
            $categories[] = $category->getId();
        }

        return [
            'name' => $provider->getName(),
            'description' => $provider->getDescription(),
            'categories' => $categories,
        ];
    }

    public function programToArray(Program $program): array
    {
        $programFormat = $program->getFormat();
        $design = $program->getDesign();

        return [
            'id' => $program->getId(),
            'name' => $program->getName(),
            'annotation' => $program->getAnnotation(),
            'description' => $program->getDetailText(),
            'locations' => $program->getLocations()->map(fn(Location $location) => $location->getId()),
            'min_price' => 0,
            'max_price' => 0,
            'level' => $program->getLevel()->getId(),
            'practice' => ($design['type'] === Program::DESIGN_SIMPLE) ? $design['value'][1] : 100,
            'format' => ($programFormat['type'] !== Program::OTHER) ? $programFormat['value'] : 0,
            'rating' => $this->programService->getAverageRating($program),
            'categories' => $program->getCategories()->map(fn(Category $category) => $category->getId())->toArray(),
        ];
    }
}
