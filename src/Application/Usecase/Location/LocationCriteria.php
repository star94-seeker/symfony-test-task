<?php

namespace App\Api\Application\Usecase\Location;

use App\Api\Application\Dto\Location\LocationCriteria as LocationCriteriaDto;
use App\Api\Port\Adapter\Http\Request\LocationCriteriaRequest;
use App\Api\Domain\Repository\Location\ILocationCriteriaRepository;

class LocationCriteria
{
    private $locationCriteriaRepository;

    public function __construct(ILocationCriteriaRepository $locationCriteriaRepository)
    {
        $this->locationCriteriaRepository =  $locationCriteriaRepository;
    }

    public function process(LocationCriteriaRequest $request)
    {
        $results = $this->locationCriteriaRepository->getResults($request);

        $locationCriteriaDto = new LocationCriteriaDto($results);

        return $locationCriteriaDto;
    }
}

//  class LocationCriteria {

//     public function __construct($data) {

//     }

//     public function jsonSerialzie() {
// //         The output is an AND expresion of all criteria (so true if all criteria are met) as well as a list of all criterion
// // and their Boolean status.

//         [
//             check => false,
// criteria => [naming=>true, daytemp=>false, rival=>true]
//         ]
//     }

// }