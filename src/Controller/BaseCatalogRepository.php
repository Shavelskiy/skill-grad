<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\SearchService;
use Exception;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseCatalogRepository extends AbstractController
{
    protected SearchService $searchService;
    protected CategoryRepository $categoryRepository;

    protected function getPageFromRequest(Request $request): int
    {
        return (int)$request->get('page', 1);
    }

    protected function getQueryFromRequest(Request $request): string
    {
        return $request->get('q', '');
    }

    protected function getCategoriesFromRequest(Request $request): array
    {
        $filterCategories = [];

        if (
            (($categoryId = (int)$request->get('category')) > 0) &&
            ($category = $this->categoryRepository->find($categoryId)) !== null
        ) {
            $filterCategories[] = $category->getId();

            try {
                if (($subcategoryId = (int)$request->get('subcategory')) < 1) {
                    throw new RuntimeException('');
                }

                if (($subcategory = $this->categoryRepository->find($subcategoryId)) === null) {
                    throw new RuntimeException('');
                }

                $filterCategories[] = $subcategory->getId();
            } catch (Exception $e) {
                /** @var Category $childCategory */
                foreach ($category->getChildCategories() as $childCategory) {
                    $filterCategories[] = $childCategory->getId();
                }
            }
        }

        return $filterCategories;
    }
}
