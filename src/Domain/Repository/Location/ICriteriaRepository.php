<?php

namespace App\Api\Domain\Repository\Location;

interface ICriteriaRepository
{
    public function validateCriteria(): bool;
}