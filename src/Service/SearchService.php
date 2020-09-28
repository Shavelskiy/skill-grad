<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\Program\Program;
use App\Entity\Provider;
use App\Search\EntityHelper;

class SearchService
{
    protected const ES_HOST = 'elasticsearch:9200';

    protected const INDEX_NAME = 'skill-grad';

    protected const TYPE_ARTICLE = 'article';
    protected const TYPE_PROVIDER = 'provider';
    protected const TYPE_PROGRAM = 'program';

    protected const PAGE_ITEM_COUNT = 10;

    public function addArticleToIndex(Article $article): void
    {
        $this->createEntityIndex(self::TYPE_ARTICLE, $article->getId(), EntityHelper::articleToArray($article));
    }

    public function addProviderToIndex(Provider $provider): void
    {
        $this->createEntityIndex(self::TYPE_PROVIDER, $provider->getId(), EntityHelper::providerToArray($provider));
    }

    public function addProgramToIndex(Program $program): void
    {
        $this->createEntityIndex(self::TYPE_PROGRAM, $program->getId(), EntityHelper::programToArray($program));
    }

    public function createEntityIndex(string $type, int $entityId, array $data): void
    {

        $this->exec("/$type/$entityId", 'PUT', $data);
    }

    public function findProviders(int $page, string $query): array
    {
        $filter = [
            'size' => self::PAGE_ITEM_COUNT,
            'from' => ($page - 1) * self::PAGE_ITEM_COUNT,
        ];

        if (!empty($query)) {
            $filter['query'] = [
                'multi_match' => [
                    'query' => $query,
                    'fields' => ['name', 'description'],
                ],
            ];
        }

        $data = $this->exec("/" . self::TYPE_PROVIDER . "/_search?_source=id", 'GET', $filter);
        $data = $data['hits'];

        $ids = [];

        foreach ($data['hits'] as $hit) {
            $ids[] = (int)($hit['_id']);
        }

        return [
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
