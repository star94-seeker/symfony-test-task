<?php

declare(strict_types=1);

namespace App\Api\Port\Adapter\Symphony\Response;

use JsonSerializable;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorResponse extends JsonResponse implements JsonSerializable
{
	/** @var string */
	private $message;

	/** @var string */
	private $requestId;

	public function __construct(string $message, int $status, string $requestId)
	{
		$this->message = $message;
		$this->requestId = $requestId;

		parent::__construct($this, $status);
	}

	public function jsonSerialize(): array
	{
		return [
			'error' => true,
			'message' => $this->message,
			'requestId' => $this->requestId,
		];
	}
}
