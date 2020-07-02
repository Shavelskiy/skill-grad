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
        $dataJson = json_encode($data);

        $url = self::ES_HOST . '/' . self::INDEX_NAME . "/$type/$entityId";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($dataJson)]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    }
}
