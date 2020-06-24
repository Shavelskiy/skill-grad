<?php

namespace App\Helpers;

use App\Dto\SearchQuery;
use Symfony\Component\HttpFoundation\Request;

class SearchHelper
{
    protected const DEFAULT_PAGE_ITEMS = 20;

    public static function createFromRequest(Request $request, array $entityClasses): SearchQuery
    {
        $tableSearch = new SearchQuery();

        self::setPageValue($request, $tableSearch);
        self::setPageItemCount($request, $tableSearch);
        self::setOrder($request, $tableSearch, $entityClasses);
        self::setSearch($request, $tableSearch, $entityClasses);

        return $tableSearch;
    }

    private static function setPageValue(Request $request, SearchQuery $tableSearch): void
    {
        $page = (int)$request->get('page', 1);

        $tableSearch->setPage($page > 0 ? $page : 1);
    }

    private static function setPageItemCount(Request $request, SearchQuery $tableSearch): void
    {
        $pageItemCount = (int)$request->get('pageItemCount', 0);

        $tableSearch->setPageItemCount($pageItemCount > 0 ? $pageItemCount : self::DEFAULT_PAGE_ITEMS);
    }

    private static function setOrder(Request $request, SearchQuery $tableSearch, array $entityClasses): void
    {
        $order = json_decode($request->get('order', ''), true);

        if (!is_array($order) || empty($order)) {
            return;
        }

        $orderField = array_key_first($order);

        foreach ($entityClasses as $entityClass) {
            if (!property_exists($entityClass, $orderField)) {
                return;
            }
        }

        $tableSearch
            ->setOrderField(array_key_first($order))
            ->setOrderType(($order[$orderField] === 'asc') ? 'asc' : 'desc');
    }

    private static function setSearch(Request $request, SearchQuery $tableSearch, array $entityClasses): void
    {
        $requerySearch = json_decode($request->get('search', ''), true);

        if (!is_array($requerySearch) || empty($requerySearch)) {
            return;
        }

        $search = [];

        foreach ($requerySearch as $field => $value) {
            if ($value === null || (!is_bool($value) && empty($value))) {
                continue;
            }

            foreach ($entityClasses as $entityClass) {
                if (!property_exists($entityClass, $field)) {
                    continue;
                }
            }

            $search[$field] = $value;
        }

        $tableSearch->setSearch($search);
    }
}
