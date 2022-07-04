<?php

namespace App\Api\Port\Adapter\Repository\Location\Criteria;;

use App\Api\Domain\Repository\Location\ICriteriaRepository;
use App\Api\Domain\Model\Location\Location;

class Rival implements ICriteriaRepository
{
    const CRITERIA_ALIAS = 'rival';

    private Location $location;

    private Location $rivalLocation;

    public function __construct(Location $location, Location $rivalLocation)
    {
        $this->location = $location;
        $this->rivalLocation = $rivalLocation;
    }


    public function validateCriteria(): bool
    {
        if ($this->location->getTemperature() > $this->rivalLocation->getTemperature()) {
            return false;
        }

        return true;
    }
}
