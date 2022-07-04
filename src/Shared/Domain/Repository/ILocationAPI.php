<?php

namespace App\Api\Shared\Domain\Repository;

use App\Api\Domain\Model\Location\Location;
use  App\Api\Shared\Domain\Request\LocationRequest;
use  App\Api\Shared\Domain\Response\LocationResponse;

interface ILocationAPI
{
  public function getResponse(): LocationResponse;
  public function setRequest(LocationRequest $locationRequest): void;
  public function getRequest(): LocationRequest;
}
