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

    protected function getPageFromRequest(Request $request, string $pageKey = 'page'): int
    {
        return (int)$request->get($pageKey, 1);
    }

    protected function getQueryFromRequest(Request $request): string
    {
        return $request->get('q', '');
    }

    protected function getProgramSearchResult(Request $request, int $page): array
    {
        return $this->searchService->findPrograms(
            $page,
            $this->getQueryFromRequest($request),
            $this->getCategoriesFromRequest($request),
            array_keys($request->get('formats', []))
        );
    }

    protected function getProviderSearchResult(Request $request, int $page): array
    {
        return $this->searchService->findProviders(
            $page,
            $this->getQueryFromRequest($request),
            $this->getCategoriesFromRequest($request)
        );
    }

    protected function getArticleSearchResult(Request $request, int $page): array
    {
        return $this->searchService->findArticles(
            $page,
            $this->getQueryFromRequest($request),
            $this->getCategoryFromRequest($request)
        );
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

    protected function getCategoryFromRequest(Request $request): ?int
    {
        $category = null;

        if (($categoryId = (int)$request->get('category')) > 0) {
            $category = $this->categoryRepository->find($categoryId);
        }

        return $category ? $category->getId() : null;
    }
}
