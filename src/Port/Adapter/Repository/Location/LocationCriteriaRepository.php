<?php

namespace App\Api\Port\Adapter\Repository\Location;

use App\Api\Port\Adapter\Http\Request\LocationCriteriaRequest;
use App\Api\Application\Service\CriteriaService;
use App\Api\Domain\Model\Location\LocationCriteria;
use App\Api\Domain\Repository\Location\ILocationCriteriaRepository;
use App\Api\Shared\Domain\Repository\ILocationAPI;
use App\Api\Shared\Domain\Request\LocationRequest;
use App\Api\Port\Adapter\Repository\Location\Criteria\Name;
use App\Api\Port\Adapter\Repository\Location\Criteria\DayTemperature;
use App\Api\Port\Adapter\Repository\Location\Criteria\Rival;
use App\Api\Shared\Domain\Repository\Cache\ICacheRepository;
use App\Api\Shared\Domain\Response\LocationResponse;

class LocationCriteriaRepository implements ILocationCriteriaRepository
{
    private ILocationAPI $locationAPI;
    private LocationCriteria $locationCriteriaModel;
    private CriteriaService $criteriaService;

    public function __construct(
        ICacheRepository $cache,
        ILocationAPI $locationAPI,
        LocationCriteriaBuilder $locationCriteriaBuilder,
        LocationCriteria $locationCriteriaModel,
        CriteriaService $criteriaService
    ) {
        $this->cache = $cache;
        $this->locationAPI = $locationAPI;
        $this->locationCriteriaBuilder = $locationCriteriaBuilder;
        $this->locationCriteriaModel = $locationCriteriaModel;
        $this->criteriaService = $criteriaService;
    }

    public function getResults(LocationCriteriaRequest $locationRequest): LocationCriteria
    {

        $locationResponse = $this->getLocationResponse($locationRequest->getLocationName());

        $locationModel = $this->locationCriteriaBuilder->buildModel($locationResponse);

        if ($this->criteriaService->isCriteriaEnabled(Name::CRITERIA_ALIAS)) {
            $naming = new Name($locationModel);
            $this->locationCriteriaModel->setNameCriteriaResponse($naming->validateCriteria());
        }

        if ($this->criteriaService->isCriteriaEnabled(DayTemperature::CRITERIA_ALIAS)) {
            $daytemp = new DayTemperature($locationModel);
            $this->locationCriteriaModel->setDayTempCriteriaResponse($daytemp->validateCriteria());
        }

        if ($this->criteriaService->isCriteriaEnabled(Rival::CRITERIA_ALIAS)) {
            $refLocation = $_ENV['APP_REFERENCE_LOCATION']; // from env
            $locationResponse = $this->getLocationResponse($refLocation);
            $locationModel2 = $this->locationCriteriaBuilder->buildModel($locationResponse);
            $rival = new Rival($locationModel, $locationModel2);
            $this->locationCriteriaModel->setRivalCriteriaResponse($rival->validateCriteria());
        }

        return $this->locationCriteriaModel;
    }

    private function getLocationResponse(string $cityName): LocationResponse
    {
        if ($response = $this->cache->getItemIfExists($cityName)) {

            return $response;
        }

        $request = new LocationRequest();

        $request->setCityname($cityName);

        $this->locationAPI->setRequest($request);

        $locationResponse = $this->locationAPI->getResponse();

        $this->cache->set($cityName, $locationResponse);

        return $locationResponse;
    }
}
