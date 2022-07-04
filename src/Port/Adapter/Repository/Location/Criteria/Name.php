<?php

namespace App\Api\Port\Adapter\Repository\Location\Criteria;

use App\Api\Domain\Repository\Location\ICriteriaRepository;
use App\Api\Domain\Model\Location\Location;

class Name implements ICriteriaRepository
{
    const CRITERIA_ALIAS = 'name';

    private Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }


    public function validateCriteria(): bool
    {
        $num = strlen($this->location->getCityName());

        if ($num % 2 == 0) {
            return false;
        }

        return true;
    }
}
