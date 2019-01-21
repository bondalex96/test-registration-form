<?php

namespace App\Infrastructure\EventListener\ExceptionsHandling;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class InternalExceptionListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($event->isPropagationStopped()) {
            return;
        }
        if (!$exception instanceof \Throwable) {
            return;
        }

        $this->logger->error('Internal error', [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
        ]);

        $event->setResponse(new JsonResponse([
            'errors' => ['Unexpected internal error']
        ], Response::HTTP_INTERNAL_SERVER_ERROR));
    }
}
