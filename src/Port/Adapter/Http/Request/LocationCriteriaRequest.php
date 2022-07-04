<?php

namespace App\Api\Port\Adapter\Http\Request;

use Symfony\Component\HttpFoundation\Request;

class LocationCriteriaRequest
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getLocationName(): string
    {
        return $this->request->get('locationName');
    }
}
