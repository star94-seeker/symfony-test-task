<?php
declare(strict_types=1);

namespace App\Api\Port\Adapter\Http;

use App\Api\Port\Adapter\Http\Request\LocationCriteriaRequest;
use App\Api\Application\Usecase\Location\LocationCriteria;
use App\Api\Core\Http\ControllerInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LocationCriteriaController implements ControllerInterface
{
    private $usecase;

    public function __construct(LocationCriteria $usecase)
    {
        $this->usecase = $usecase;
    }

    public function __invoke(Request $request): Response
    {
        $locationRequest = new LocationCriteriaRequest($request);

        $response = $this->usecase->process($locationRequest);

        if (empty($response)) {
            $response = ["error" => true];
        }

        return new JsonResponse($response, JsonResponse::HTTP_OK);
    }
}
