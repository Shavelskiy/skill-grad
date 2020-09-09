<?php

namespace App\Twig;

use App\Cache\Keys;
use App\Cache\MemcachedClient;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use ErrorException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Exception\CacheException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getMenuItems', [$this, 'getMenuItemsCached']),
        ];
    }

    /**
     * @throws CacheException
     * @throws ErrorException
     * @throws InvalidArgumentException
     */
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

    /**
     * @throws CacheException
     */
    protected function getMenuItems(): array
    {
        $result = [];

        /** @var Category $rootCategory */
        foreach ($this->categoryRepository->findRootCategories() as $rootCategory) {
            $childCategories = [];

            /** @var Category $childCategory */
            foreach ($rootCategory->getChildCategories() as $childCategory) {
                $childCategories[] = [
                    'name' => $childCategory->getName(),
                    'slug' => $childCategory->getSlug(),
                ];
            }

            $result[] = [
                'name' => $rootCategory->getName(),
                'childCategories' => $childCategories,
            ];
        }

        return $result;
    }
}
