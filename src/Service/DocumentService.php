<?php

namespace App\Service;

use App\Entity\Service\Document;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\RouterInterface;

class DocumentService
{
    protected const FILE_DOWNLOAD_PATH = 'api.document.download';

    protected const FILES_DIR_PARAM_KEY = 'files_dir';

    protected RouterInterface $router;
    protected string $replenishDir;

    public function __construct(
        ParameterBagInterface $params,
        RouterInterface $router
    ) {
        $this->router = $router;
        $this->replenishDir = $params->get(self::FILES_DIR_PARAM_KEY). '/replenish';
    }

    public function generateDownloadPath(Document $document): string
    {
        return $this->router->generate(self::FILE_DOWNLOAD_PATH, ['document' => $document->getId()]);
    }

    public function getAbsolutePath(Document $document): string
    {
        return sprintf('%s/%s', $this->replenishDir, $document->getPath());
    }
}
