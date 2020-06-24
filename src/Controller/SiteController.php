<?php

namespace App\Controller;

use App\Cache\Keys;
use App\Cache\MemcachedClient;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use ErrorException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Exception\CacheException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    protected ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/", name="site.index")
     *
     * @throws CacheException
     * @throws ErrorException
     * @throws InvalidArgumentException
     */
    public function index(): Response
    {
        return $this->render('site/index.html.twig', [
            'articles' => $this->getArticles(),
        ]);
    }

    /**
     * @throws ErrorException
     * @throws InvalidArgumentException
     * @throws CacheException
     */
    protected function getArticles(): array
    {
        $result = function () {
            $result = [];

            /** @var Article $article */
            foreach ($this->articleRepository->getMainPageArticles() as $article) {
                $result[] = [
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

        $cache = MemcachedClient::getCache();

        /** @var CacheItemInterface $item */
        $item = $cache->getItem(Keys::MAIN_BLOG);

        if (!$item->isHit()) {
            $item->set($result());
            $item->expiresAfter(360000);
            $cache->save($item);
        }

        return $item->get();
    }
}
