<?php

namespace App\Api\Shared\Domain\Request;

class LocationRequest
{

    private string $cityName;

    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }
}
