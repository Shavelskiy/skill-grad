<?php

namespace App\Controller\Api;

use App\Entity\Service\Document;
use App\Service\DocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/document")
 */
class DocumentController extends AbstractController
{
    protected DocumentService $documentService;

    public function __construct(
        DocumentService $documentService
    ) {
        $this->documentService = $documentService;
    }

    /**
     * @Route("/{document}", name="api.document.download", methods={"GET"})
     */
    public function download(Document $document): Response
    {
        if ($document->getService()->getUser()->getId() !== $this->getUser()->getId()) {
            return new JsonResponse([], 403);
        }

        return $this->file(
            $this->documentService->getAbsolutePath($document)
        );
    }
}