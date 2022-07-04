<?php

namespace App\Api\Domain\Model\Location;

class LocationCriteria
{
    private  $nameCriteriaResponse = null;
    private  $dayTempCriteriaResponse = null;
    private  $rivalCriteriaResponse = null;

    public function hasValidNameCriteria()
    {
        return $this->nameCriteriaResponse;
    }

    public function hasValidDayTempCriteria()
    {
        return $this->dayTempCriteriaResponse;
    }

    public function hasValidRivalCriteria()
    {
        return $this->rivalCriteriaResponse;
    }

    public function setNameCriteriaResponse(bool $value): void
    {
        $this->nameCriteriaResponse = $value;
    }

    public function setDayTempCriteriaResponse(bool $value): void
    {
        $this->dayTempCriteriaResponse = $value;
    }

    public function setRivalCriteriaResponse(bool $value): void
    {
        $this->rivalCriteriaResponse = $value;
    }
}
