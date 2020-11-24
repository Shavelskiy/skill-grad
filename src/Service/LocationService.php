<?php

namespace App\Service;

use App\Entity\Location;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LocationService
{
    public const DEFAULT_LOCATION_CODE = 'moskva';

    protected string $scheme;
    protected string $host;

    protected Location $currentLocation;

    public function __construct(
        ParameterBagInterface $parameterBag
    ) {
        $this->scheme = $parameterBag->get('app_scheme');
        $this->host = $parameterBag->get('app_host');
    }

    public function generateLocationLink(Location $location): string
    {
        return sprintf('%s://%s.%s', $this->scheme, $location->getCode(), $this->host);
    }

    public function getLocationPath(Location $location): string
    {
        $path = [];
        $parentLocation = clone $location;

        while ($parentLocation !== null) {
            $path[] = $parentLocation->getName();
            $parentLocation = $parentLocation->getParentLocation();
        }

        return implode(', ', $path);
    }

    public function getCurrentLocation(): Location
    {
        return $this->currentLocation;
    }

    public function setCurrentLocation(Location $currentLocation): self
    {
        $this->currentLocation = $currentLocation;
        return $this;
    }
}
