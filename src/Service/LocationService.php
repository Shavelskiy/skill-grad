<?php

namespace App\Service;

use App\Entity\Location;

class LocationService
{
    public const DEFAULT_LOCATION_CODE = 'moskva';

    protected Location $currentLocation;

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
