<?php

namespace App\Service;

use App\Entity\Service\Document;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DocumentService
{
    public const FILE_DOWNLOAD_PATH = 'api.document.download';

    protected const REPLENISH_DIR_PARAM_KEY = 'replenish_dir';

    protected string $replenishDir;

    public function __construct(
        ParameterBagInterface $params
    ) {
        $this->replenishDir = $params->get(self::REPLENISH_DIR_PARAM_KEY);
    }

    public function getAbsolutePath(Document $document): string
    {
        return sprintf('%s/%s', $this->replenishDir, $document->getPath());
    }
}
