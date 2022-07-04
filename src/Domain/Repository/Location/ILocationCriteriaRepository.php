<?php

namespace App\Api\Domain\Repository\Location;

use App\Api\Port\Adapter\Http\Request\LocationCriteriaRequest;

interface ILocationCriteriaRepository
{
    public function getResults(LocationCriteriaRequest $request);
}