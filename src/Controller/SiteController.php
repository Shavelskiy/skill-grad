<?php

namespace App\Controller;

use App\Controller\Traits\SeoTrait;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Program\Program;
use App\Entity\Provider;
use App\Enum\Cache\Keys;
use App\Enum\PagesKeys;
use App\Helpers\MemcachedClient;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\Content\Seo\DefaultSeoRepository;
use App\Repository\ProgramRepository;
use App\Service\ProgramService;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class SiteController extends AbstractController
{
    use SeoTrait;

    protected ArticleRepository $articleRepository;
    protected CategoryRepository $categoryRepository;
    protected ProgramRepository $programRepository;
    protected ProgramService $programService;

    public function __construct(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        ProgramRepository $programRepository,
        ProgramService $programService,
        DefaultSeoRepository $defaultSeoRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->programRepository = $programRepository;
        $this->programService = $programService;

        $this->setDefaultSeoRepository($defaultSeoRepository);
    }

    /**
     * @Route("/", name="site.index")
     */
    public function index(): Response
    {
        return $this->render('site/index.html.twig', $this->applySeoToDefaultPage([
            'articles' => $this->getArticles(),
            'sliderItems' => $this->getSliderItems(),
        ], PagesKeys::INDEX_PAGE));
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
                    $provider = $program->getProviders()->first();

                    $programs[] = [
                        'id' => $program->getId(),
                        'name' => $program->getName(),
                        'provider' => [
                            'name' => $provider->getName(),
                            'image' => $provider->getImage() ? $provider->getImage()->getPublicPath() : null,
                        ],
                        'rating' => $this->programService->getAverageRating($program),
                        'annotation' => $program->getAnnotation(),
                        'price' => $this->programService->getPrice($program),
                        'oldPrice' => $this->programService->getOldPrice($program),
                        'discount' => $this->programService->isDiscount($program),
                        'showPriceReduction' => $program->isShowPriceReduction(),
                        'format' => $program->getProgramFormat() !== null ? $program->getProgramFormat()->getName() : $program->getFormatOther(),
                        'duration' => $this->programService->getDuration($program),
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
