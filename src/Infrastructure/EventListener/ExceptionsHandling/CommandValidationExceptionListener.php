<?php

namespace App\Infrastructure\EventListener\ExceptionsHandling;

use App\Infrastructure\CommandBus\ValidationCommandException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class CommandValidationExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof ValidationCommandException) {
            return;
        }

        $event->setResponse(new JsonResponse(['errors' => $exception->getErrorsMessages()], Response::HTTP_BAD_REQUEST));
    }
}
