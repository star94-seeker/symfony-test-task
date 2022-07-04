<?php

declare(strict_types=1);

namespace App\Api\Port\Adapter\Symphony\EventListener;

use App\Api\Application\Exceptions\LocationNotFoundException;
use App\Api\Port\Adapter\Symphony\Response\ErrorResponse;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
	/** @var LoggerInterface */
	private $logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	public function __invoke(ExceptionEvent $event)
	{   
        $exception = $event->getThrowable();

		$request = $event->getRequest();

		$requestId = $request->headers->get('X_REQUEST_ID') ?? "A unique ID must be sent from client side";

		//Default values
		$msg = 'Unable to process the request';
		$statusCode = JsonResponse::HTTP_BAD_REQUEST;

		if ($exception instanceof LocationNotFoundException) {
			$msg = $exception->getMessage();
			$statusCode = $exception->getCode();
		}

		$errorResponse = new ErrorResponse($msg, $statusCode, $requestId);

		$event->setResponse($errorResponse);

		if ($statusCode !== JsonResponse::HTTP_NOT_FOUND) {
			$this->log($msg, $exception);
		}
	}

	private function log(string $message, Exception $exception): void
	{
		$context = [
			'code' => $exception->getCode(),
			'original_message' => $exception->getMessage(),
			'called' => [
				'file' => $exception->getTrace()[0]['file'],
				'line' => $exception->getTrace()[0]['line'],
			],
			'occurred' => [
				'file' => $exception->getFile(),
				'line' => $exception->getLine(),
			],
			'trace' => $exception->getTraceAsString(),
		];

		$this->logger->error($message, $context);
	}
}

