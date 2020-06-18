<?php

namespace App\Service;

use App\Entity\Location;

class LocationService
{
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
}
