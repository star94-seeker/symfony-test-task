<?php

namespace App\Api\Port\Adapter\Repository\Location\Criteria;;

use App\Api\Domain\Model\Location\Location;
use App\Api\Domain\Repository\Location\ICriteriaRepository;

class DayTemperature implements ICriteriaRepository
{
    const CRITERIA_ALIAS = 'daytemp';

    private Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function validateCriteria(): bool
    {
        $currentTime = $this->getcurrentTime();
        $getTemperature = $this->location->getTemperature();
        $getTemperature = $getTemperature - 273.15; // convert into degrees celcius
        if ($currentTime > $this->location->getSunriseInUnix() && $currentTime < $this->location->getSunsetInUnix()) {
            if ($getTemperature > $_ENV['APP_NIGHT_TEMPERATURE_MIN'] && $getTemperature < $_ENV['APP_NIGHT_TEMPERATURE_MAX']) {
                return true;
            }
        } else {
            if ($getTemperature > $_ENV['APP_DAY_TEMPERATURE_MIN'] && $getTemperature < $_ENV['APP_DAY_TEMPERATURE_MAX']) {
                return true;
            }
        }

        return false;
    }

    private function getcurrentTime()
    {
        date_default_timezone_set("Europe/Berlin");
        return time();
    }
}
