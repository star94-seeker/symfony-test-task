<?php

namespace App\Api\Port\Adapter\Repository\Location;

use App\Api\Domain\Model\Location\Location;
use  App\Api\Shared\Domain\Response\LocationResponse;

class LocationCriteriaBuilder
{
    public function buildModel(LocationResponse $response): Location
    {
        $locationModel = new Location();
        $locationModel->setCityName($response->getCityName());
        $locationModel->setTemperature($response->getTemperature());
        $locationModel->setSunsetInUnix($response->getSunsetInUnix());
        $locationModel->setSunriseInUnix($response->getSunriseInUnix());
        return $locationModel;
    }
}
