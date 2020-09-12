<?php

namespace App\Controller;

use App\Cache\Keys;
use App\Cache\MemcachedClient;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class SiteController extends AbstractController
{
    protected ArticleRepository $articleRepository;
    protected CategoryRepository $categoryRepository;
    protected ProgramRepository $programRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->programRepository = $programRepository;
    }

    /**
     * @Route("/", name="site.index")
     */
    public function index(): Response
    {
        return $this->render('site/index.html.twig', [
            'articles' => $this->getArticles(),
            'sliderItems' => $this->getSliderItems(),
        ]);
    }

    protected function getSliderItems(): array
    {
        $result = [];

        /** @var Category $category */
        foreach ($this->categoryRepository->findRootCategories() as $category) {
            $result[] = [
                'category' => $category->getName(),
                'programs' => $this->programRepository->getNewCategoryPrograms($category),
            ];
        }

        return $result;
    }

    protected function getArticles(): array
    {
        $result = function () {
            $result = [];

            /** @var Article $article */
            foreach ($this->articleRepository->getMainPageArticles() as $article) {
                $result[] = [
                    'id' => $article->getId(),
                    'slug' => $article->getSlug(),
                    'imageSrc' => $article->getImage() ? $article->getImage()->getPublicPath() : null,
                    'name' => $article->getName(),
                    'previewText' => substr(strip_tags($article->getDetailText(), '<br>'), 0, 200) . '...',
                    'createdAt' => [
                        'day' => $article->getCreatedAt()->format('d'),
                        'month' => $article->getCreatedAt()->format('m'),
                    ],
                ];
            }

            return $result;
        };

        return $result();

        try {
            $cache = MemcachedClient::getCache();

            /** @var CacheItemInterface $item */
            $item = $cache->getItem(Keys::MAIN_BLOG);

            if (!$item->isHit()) {
                $item->set($result());
                $item->expiresAfter(360000);
                $cache->save($item);
            }

            return $item->get();
        } catch (Throwable $e) {
            return [];
        }
    }
}
