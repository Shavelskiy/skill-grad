<?php

namespace App\Controller;

use App\Cache\Keys;
use App\Cache\MemcachedClient;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Program\Program;
use App\Entity\Provider;
use App\Messenger\Pdf;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Service\ProgramService;
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
    protected ProgramService $programService;

    public function __construct(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository,
        ProgramService $programService
    ) {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->programRepository = $programRepository;
        $this->programService = $programService;
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
        $result = function () {
            $result = [];

            /** @var Category $category */
            foreach ($this->categoryRepository->findRootCategories() as $category) {
                $programs = [];

                /** @var Program $program */
                foreach ($this->programRepository->getNewCategoryPrograms($category) as $program) {
                    /** @var Provider $provider */
                    $provider = $program->getProviders()[0];

                    $programs[] = [
                        'id' => $program->getId(),
                        'name' => $program->getName(),
                        'provider' => [
                            'name' => $provider->getName(),
                            'image' => $provider->getImage() ? $provider->getImage()->getPublicPath() : null,
                        ],
                        'rating' => $this->programService->getAverageRating($program),
                        'annotation' => $program->getAnnotation(),
                        'oldPrice' => $program->getOldPrice(),
                        'additional' => $this->programService->programAdditional($program),
                    ];
                }

                $result[] = [
                    'category' => $category->getName(),
                    'programs' => $programs,
                ];
            }

            return $result;
        };

        try {
            $cache = MemcachedClient::getCache();

            /** @var CacheItemInterface $item */
            $item = $cache->getItem(Keys::MAIN_SLIDER);

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

    protected function getArticles(): array
    {
        $result = function () {
            $result = [];

            /** @var Article $article */
            foreach ($this->articleRepository->findMainPageArticles() as $article) {
                $result[] = [
                    'id' => $article->getId(),
                    'imageSrc' => $article->getImage() ? $article->getImage()->getPublicPath() : null,
                    'name' => $article->getName(),
                    'previewText' => $article->getPreviewText(),
                    'createdAt' => [
                        'day' => $article->getCreatedAt()->format('d'),
                        'month' => $article->getCreatedAt()->format('m'),
                    ],
                ];
            }

            return $result;
        };

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
