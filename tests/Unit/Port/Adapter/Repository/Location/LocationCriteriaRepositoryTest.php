<?php

namespace App\Tests\Unit\Port\Adapter\Repository\Location;

use App\Api\Port\Adapter\Http\Request\LocationCriteriaRequest;
use App\Api\Application\Service\CriteriaService;
use App\Api\Domain\Model\Location\Location;
use App\Api\Domain\Model\Location\LocationCriteria;
use App\Api\Shared\Domain\Repository\ILocationAPI;
use App\Api\Port\Adapter\Repository\Location\LocationCriteriaBuilder;
use App\Api\Port\Adapter\Repository\Location\LocationCriteriaRepository;
use App\Api\Shared\Domain\Repository\Cache\ICacheRepository;
use App\Api\Shared\Domain\Response\LocationResponse;
use App\Tests\Unit\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class LocationCriteriaRepositoryTest extends TestCase
{
    use ProphecyTrait;

    public function test_getResults_returns_cached_response()
    {   
        $cityName = "koln";

        $cache = $this->prophesize(ICacheRepository::class);
        $locationApi = $this->prophesize(ILocationAPI::class);
        $locationCriteriaBuilder = $this->prophesize(LocationCriteriaBuilder::class);
        $locationCriteria = $this->prophesize(LocationCriteria::class);
        $criteriaService = $this->prophesize(CriteriaService::class);
        $locationCriteriaRequest = $this->prophesize(LocationCriteriaRequest::class);

        $locationCriteriaRequest->getLocationName()->willReturn($cityName);
        $cache->getItemIfExists($cityName)->willReturn(new LocationResponse());
        $locationCriteriaBuilder->buildModel(new LocationResponse())->willReturn(new Location());


        $locationCriteriaRepository = new LocationCriteriaRepository(
            $cache->reveal(),
            $locationApi->reveal(),
            $locationCriteriaBuilder->reveal(),
            $locationCriteria->reveal(),
            $criteriaService->reveal(),
        );

        $response = $locationCriteriaRepository->getResults($locationCriteriaRequest->reveal());

        $this->assertInstanceOf(LocationCriteria::class, $response);
        $this->assertInstanceOf(LocationResponse::class,  $cache->reveal()->getItemIfExists($cityName));
    }
}
