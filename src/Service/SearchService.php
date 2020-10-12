<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Program\Program;
use App\Entity\Provider;

class SearchService
{
    protected const ES_HOST = 'elasticsearch:9200';

    protected const INDEX_NAME = 'skill-grad';

    protected const TYPE_ARTICLE = 'article';
    protected const TYPE_PROVIDER = 'provider';
    protected const TYPE_PROGRAM = 'program';

    protected const PAGE_ITEM_COUNT = 10;

    protected EntityMapper $entityMapper;

    public function __construct(
        EntityMapper $entityMapper
    ) {
        $this->entityMapper = $entityMapper;
    }

    public function addArticleToIndex(Article $article): void
    {
        if (!$article->isActive()) {
            return;
        }

        $this->createEntityIndex(self::TYPE_ARTICLE, $article->getId(), $this->entityMapper->articleToArray($article));
    }

    public function addProviderToIndex(Provider $provider): void
    {
        $this->createEntityIndex(self::TYPE_PROVIDER, $provider->getId(), $this->entityMapper->providerToArray($provider));
    }

    public function addProgramToIndex(Program $program): void
    {
        if (!$program->isActive()) {
            return;
        }

        $this->createEntityIndex(self::TYPE_PROGRAM, $program->getId(), $this->entityMapper->programToArray($program));
    }

    public function removeArticleFromIndex(int $articleId): void
    {
        $this->removeEntityFromIndex(self::TYPE_ARTICLE, $articleId);
    }

    public function removeProviderFromIndex(int $providerId): void
    {
        $this->removeEntityFromIndex(self::TYPE_PROVIDER, $providerId);
    }

    public function removeProgramFromIndex(int $programId): void
    {
        $this->removeEntityFromIndex(self::TYPE_PROGRAM, $programId);
    }

    protected function createEntityIndex(string $type, int $entityId, array $data): void
    {
        $this->exec("/$type/$entityId", 'PUT', $data);
    }

    protected function removeEntityFromIndex(string $type, int $entityId): void
    {
        $this->exec("/$type/$entityId", 'DELETE', []);
    }

    public function findProviders(int $page, string $query, array $categories): array
    {
        $filter = [
            'size' => self::PAGE_ITEM_COUNT,
            'from' => ($page - 1) * self::PAGE_ITEM_COUNT,
            'query' => [
                'bool' => [
                    'must' => [],
                ],
            ],
        ];

        if (!empty($query)) {
            $filter['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        ['match' => ['name' => $query]],
                        ['match' => ['description' => $query]],
                    ],
                ],
            ];
        }

        $filter = $this->applyArrayToFilter('categories', $filter, $categories);

        return $this->execSearchRequest(self::TYPE_PROVIDER, $filter);
    }

    public function findArticles(int $page, string $query, ?int $categoryId): array
    {
        $filter = [
            'size' => self::PAGE_ITEM_COUNT,
            'from' => ($page - 1) * self::PAGE_ITEM_COUNT,
            'query' => [
                'bool' => [
                    'must' => [],
                ],
            ],
        ];

        if (!empty($query)) {
            $filter['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        ['match' => ['name' => $query]],
                        ['match' => ['previewText' => $query]],
                        ['match' => ['detailText' => $query]],
                    ],
                ],
            ];
        }

        if ($categoryId !== null) {
            $filter['query']['bool']['must'][] = ['match' => ['category' => $categoryId]];
        }

        return $this->execSearchRequest(self::TYPE_ARTICLE, $filter);
    }

    public function findPrograms(int $page, string $query, array $categories, array $formats, array $providers = []): array
    {
        $filter = [
            'size' => self::PAGE_ITEM_COUNT,
            'from' => ($page - 1) * self::PAGE_ITEM_COUNT,
            'query' => [
                'bool' => [
                    'must' => [],
                ],
            ],
        ];

        if ($page < 1) {
            $filter['size'] = 9999;
            $filter['from'] = 0;
        }

        if (!empty($query)) {
            $filter['query']['bool']['must'][] = [
                'bool' => [
                    'should' => [
                        ['match' => ['name' => $query]],
                        ['match' => ['annotation' => $query]],
                        ['match' => ['description' => $query]],
                    ],
                ],
            ];
        }

        $filter = $this->applyArrayToFilter('categories', $filter, $categories);
        $filter = $this->applyArrayToFilter('format', $filter, $formats);
        $filter = $this->applyArrayToFilter('providers', $filter, $providers);

        return $this->execSearchRequest(self::TYPE_PROGRAM, $filter);
    }

    protected function applyArrayToFilter(string $field, array $filter, array $categories): array
    {
        if (!empty($categories)) {
            $categoryQuery = [];

            foreach ($categories as $category) {
                $categoryQuery[] = ['match' => [$field => $category]];
            }

            $filter['query']['bool']['must'][] = [
                'bool' => [
                    'should' => $categoryQuery,
                ],
            ];
        }

        return $filter;
    }

    protected function execSearchRequest(string $type, array $filter): array
    {
        $data = $this->exec("/$type/_search?_source=id", 'GET', $filter);

        $data = $data['hits'];

        $ids = [];

        foreach ($data['hits'] as $hit) {
            $ids[] = (int)($hit['_id']);
        }

        return [
            'total_items' => $data['total'],
            'total_pages' => ceil($data['total'] / self::PAGE_ITEM_COUNT),
            'ids' => $ids,
        ];
    }

    protected function exec(string $url, string $method, ?array $data = null): array
    {
        $requestUrl = self::ES_HOST . '/' . self::INDEX_NAME . $url;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($data !== null) {
            $dataJson = json_encode($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($dataJson)]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, JSON_OBJECT_AS_ARRAY);
    }
}
