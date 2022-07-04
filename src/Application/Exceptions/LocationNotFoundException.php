<?php

declare(strict_types=1);

namespace App\Api\Application\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class LocationNotFoundException extends Exception implements ILocationCriteriaException
{
    const MESSAGE = 'Requested location not found.';
    const STATUS_CODE = JsonResponse::HTTP_NOT_FOUND;

    public function __construct(string $message = self::MESSAGE, int $code = self::STATUS_CODE)
    {
        parent::__construct($message, $code);
    }
}
