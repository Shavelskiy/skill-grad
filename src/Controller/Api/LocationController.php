<?php

namespace App\Controller\Api;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/location")
 */
class LocationController extends AbstractController
{
    protected LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @Route("/all")
     */
    public function fetchAll(): Response
    {
        $result = [];

        /** @var Location $city */
        foreach ($this->locationRepository->findCityForList() as $city) {
            $result[] = [
                'id' => $city->getId(),
                'name' => $city->getName(),
                'type' => $city->getType(),
            ];
        }

        /** @var Location $region */
        foreach ($this->locationRepository->findAllRegions() as $region) {
            $subregions = [];

            /** @var Location $childLocation */
            foreach ($region->getChildLocations() as $childLocation) {
                $subregions[] = [
                    'id' => $childLocation->getId(),
                    'name' => $childLocation->getName(),
                ];
            }

            $result[] = [
                'id' => $region->getId(),
                'name' => $region->getName(),
                'type' => $region->getType(),
                'subregions' => $subregions,
            ];
        }


        return new JsonResponse($result);
    }
}