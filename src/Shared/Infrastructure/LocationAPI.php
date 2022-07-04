<?php

namespace App\Api\Shared\Infrastructure;

use App\Api\Shared\Domain\Repository\ILocationAPI;
use App\Api\Shared\Domain\Request\LocationRequest;
use  App\Api\Shared\Domain\Response\LocationResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Api\Application\Exceptions\LocationNotFoundException;

class LocationAPI extends AbstractController  implements ILocationAPI
{
    private $url;

    private $request;

    private function buildUrl(string $cityName)
    {
        $apiKey = $_ENV['APP_LOCATION_API_KEY']; // From env

        $apiURL = $_ENV['APP_LOCATION_API_URL']; // From env

        $queryData = array(
            'q' => str_replace(' ', '%20', $cityName) . ",de",
            'appid' => $apiKey
        );

        $this->url = $apiURL . "?" . http_build_query($queryData);
    }

    private function getUrl(): string
    {
        return $this->url;
    }

    private function sendRequest()
    {
        $content = @file_get_contents($this->getUrl());

        if ($content === false) {
            throw new LocationNotFoundException();
            // new exception class
        }

        return json_decode($content);
    }

    public function setRequest(LocationRequest $locationRequest): void
    {
        $this->request = $locationRequest;
    }

    public function getRequest(): LocationRequest
    {
        return $this->request;
    }

    public function getResponse(): LocationResponse
    {
        $request = $this->getRequest();

        if (!$request instanceof LocationRequest) {
            throw new \Exception("Request not found");
        }

        $cityName = $request->getCityName();

        if (empty($cityName)) {
            throw new \Exception("Required parameter CityName missing");
        }

        $this->buildUrl($cityName);

        $response =  $this->sendRequest();  //api response

        return $this->buildResponse($response);
    }

    private function buildResponse($data): LocationResponse
    {
        $locationResponse = new LocationResponse();

        $locationResponse->setCityName($data->name);

        $locationResponse->setTemperature($data->main->temp);

        $locationResponse->setSunsetInUnix($data->sys->sunset);

        $locationResponse->setSunriseInUnix($data->sys->sunrise);

        return $locationResponse;
    }
}
