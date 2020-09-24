<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    protected ProgramRepository $programRepository;
    protected ProviderRepository $providerRepository;

    public function __construct(
        ProgramRepository $programRepository,
        ProviderRepository $providerRepository
    ) {
        $this->programRepository = $programRepository;
        $this->providerRepository = $providerRepository;
    }

    /**
     * @Route("/search", name="app.search", methods={"GET"})
     */
    public function index(): Response
    {
        $favoriteProviderIds = [];

        if ($this->getUser()) {
            foreach ($this->getUser()->getFavoriteProviders() as $provider) {
                $favoriteProviderIds[] = $provider->getId();
            }
        }

        return $this->render('search/index.html.twig', [
            'programs' => $this->programRepository->findBy(['id' => [1, 2, 5, 48, 32, 32]]),
            'providers' => $this->providerRepository->findBy(['id' => [23, 89, 143, 289]]),
            'favorite_provider_ids' => $favoriteProviderIds,
        ]);
    }
}
