<?php

namespace App\Api\Application\Dto\Location;

use App\Api\Domain\Model\Location\LocationCriteria as LocationCriteriaModel;
use JsonSerializable;

class LocationCriteria  implements JsonSerializable
{
    private $locationCriteriaModel;
    private $criteriaResponse = [];

    public function __construct(LocationCriteriaModel $locationCriteriaModel)
    {
        $this->locationCriteriaModel =  $locationCriteriaModel;
    }

    public function jsonSerialize(): array
    {
        $this->buildCriteriaResponse('naming', $this->locationCriteriaModel->hasValidNameCriteria());

        $this->buildCriteriaResponse('daytemp', $this->locationCriteriaModel->hasValidDayTempCriteria());

        $this->buildCriteriaResponse('rival', $this->locationCriteriaModel->hasValidRivalCriteria());

        return [
            'check' => $this->getCheckValue(),
            'criteria' => $this->getCriteriaResponse(),
        ];
    }

    private function buildCriteriaResponse(string $key, $value)
    {
        if (isset($value)) {
            $this->criteriaResponse[$key] = $value;
        }
    }

    private function getCriteriaResponse(): array
    {
        return $this->criteriaResponse;
    }

    private function getCheckValue()
    {
        if (!empty($this->criteriaResponse) && in_array(false, $this->criteriaResponse)) {
            return false;
        }
    }
}
