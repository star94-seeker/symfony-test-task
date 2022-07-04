<?php

namespace App\Api\Port\Adapter\Http;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LocationCriteriaControllerTest extends KernelTestCase
{

    public function test__invoke()
    {
        $cityName = "Köln";

        self::bootKernel();

        $container = static::getContainer();

        $controller = $container->get(LocationCriteriaController::class);

        $resposne = $controller->__invoke(new Request(['locationName' => $cityName]));
        $this->assertEquals(JsonResponse::HTTP_OK,  $resposne->getStatusCode());
    }
}
