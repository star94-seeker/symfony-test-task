<?php

namespace App\Api\Domain\Model\Location;

class Location
{
    private float $temperature;
    private int $sunriseInUnix;
    private int $sunsetInUnix;
    private string $cityName;

    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }

    public function setTemperature(float $temperature): void
    {
        $this->temperature = $temperature;
    }

    public function getTemperature(): string
    {
        return $this->temperature;
    }

    public function setSunsetInUnix(int $sunsetInUnix): void
    {
        $this->sunsetInUnix = $sunsetInUnix;
    }

    public function setSunriseInUnix(int $sunriseInUnix): void
    {
        $this->sunriseInUnix = $sunriseInUnix;
    }

    public function getSunsetInUnix(): int
    {
        return $this->sunsetInUnix;
    }

    public function getSunriseInUnix(): int
    {
        return $this->sunriseInUnix;
    }
}
