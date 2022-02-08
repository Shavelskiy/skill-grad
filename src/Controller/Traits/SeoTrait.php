<?php

namespace App\Controller\Traits;

use App\Entity\Article;
use App\Entity\Content\Page;
use App\Entity\Content\Seo\AbstractSeo;
use App\Entity\Program\Program;
use App\Entity\Provider;
use App\Repository\Content\Seo\DefaultSeoRepository;
use RuntimeException;

trait SeoTrait
{
    protected ?DefaultSeoRepository $defaultSeoRepository = null;

    protected function setDefaultSeoRepository(DefaultSeoRepository $defaultSeoRepository): void
    {
        $this->defaultSeoRepository = $defaultSeoRepository;
    }

    protected function applySeoToProvider(array $data, Provider $provider): array
    {
        if ($provider->getSeo() === null) {
            return $data;
        }

        return array_merge($data, $this->getSeoData($provider->getSeo()));
    }

    protected function applySeoToProgram(array $data, Program $program): array
    {
        if ($program->getSeo() === null) {
            return $data;
        }

        return array_merge($data, $this->getSeoData($program->getSeo()));
    }

    protected function applySeoToArticle(array $data, Article $article): array
    {
        if ($article->getSeo() === null) {
            return $data;
        }

        return array_merge($data, $this->getSeoData($article->getSeo()));
    }

    protected function applySeoToPage(array $data, Page $page): array
    {
        if ($page->getSeo() === null) {
            return $data;
        }

        return array_merge($data, $this->getSeoData($page->getSeo()));
    }

    protected function applySeoToDefaultPage(array $data, string $pageSlug): array
    {
        if ($this->defaultSeoRepository === null) {
            throw new RuntimeException('Default seo repository not defined in seo trait');
        }

        if (($defaultSeo = $this->defaultSeoRepository->findOneBy(['pageSlug' => $pageSlug])) === null) {
            return $data;
        }

        return array_merge($data, $this->getSeoData($defaultSeo));
    }

    protected function getSeoData(AbstractSeo $seo): array
    {
        return [
            'meta_title' => $seo->getMetaTitle(),
            'meta_description' => $seo->getMetaDescription(),
            'meta_keywords' => $seo->getMetaKeywords(),
        ];
    }
}
