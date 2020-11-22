<?php

namespace App\Twig;

use App\Entity\Category;
use App\Enum\Cache\Keys;
use App\Helpers\MemcachedClient;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use Psr\Cache\CacheItemInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    protected CategoryRepository $categoryRepository;
    protected LocationRepository $locationRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->locationRepository = $locationRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getMenuItems', [$this, 'getMenuItemsCached']),
            new TwigFunction('getListLocations', [$this, 'getListLocationsCached']),
        ];
    }

    public function getMenuItemsCached(): array
    {
        $cache = MemcachedClient::getCache();

        /** @var CacheItemInterface $item */
        $item = $cache->getItem(Keys::HEADER_MENU);

        if (!$item->isHit()) {
            $item->set($this->getMenuItems());
            $item->expiresAfter(360000);
            $cache->save($item);
        }

        return $item->get();
    }

    protected function getMenuItems(): array
    {
        $result = [];

        foreach ($this->categoryRepository->findRootCategories() as $rootCategory) {
            $childCategories = [];

            /** @var Category $childCategory */
            foreach ($rootCategory->getChildCategories() as $childCategory) {
                $childCategories[] = [
                    'id' => $childCategory->getId(),
                    'name' => $childCategory->getName(),
                    'slug' => $childCategory->getSlug(),
                ];
            }

            $result[] = [
                'id' => $rootCategory->getId(),
                'name' => $rootCategory->getName(),
                'childCategories' => $childCategories,
            ];
        }

        return $result;
    }

    public function getListLocationsCached(): array
    {
        $cache = MemcachedClient::getCache();

        /** @var CacheItemInterface $item */
        $item = $cache->getItem(Keys::HEADER_LOCATIONS);

        if (!$item->isHit()) {
            $item->set($this->getListLocations());
            $item->expiresAfter(360000);
            $cache->save($item);
        }

        return $item->get();
    }

    public function getListLocations(): array
    {
        $result = [];

        foreach ($this->locationRepository->findCityForList() as $location) {
            $result[] = [
                'id' => $location->getId(),
                'name' => $location->getName(),
                'highlight' => $location->getId() < 10,
            ];
        }

        return $result;
    }
}
