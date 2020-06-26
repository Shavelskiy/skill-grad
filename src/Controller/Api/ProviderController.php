<?php

namespace App\Controller\Api;

use App\Entity\Provider;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/provider")
 */
class ProviderController extends AbstractController
{
    protected ProviderRepository $providerRepository;

    public function __construct(ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    /**
     * @Route("/all")
     */
    public function getAll(): Response
    {
        $result = [];

        /** @var Provider $provider */
        foreach ($this->providerRepository->findAll() as $provider) {
            $result[] = [
              'id' => $provider->getId(),
              'name' => $provider->getName(),
              'comment' => $provider->getDescription(),
              'image' => $provider->getImage() ? $provider->getImage()->getPublicPath() : null,
            ];
        }

        return new JsonResponse($result);
    }
}
