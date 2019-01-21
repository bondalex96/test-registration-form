<?php

namespace App\Infrastructure\EventListener\ExceptionsHandling;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class DomainExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof \DomainException) {
            return;
        }

        $event->setResponse(new JsonResponse(['errors' => $exception->getMessage()], Response::HTTP_BAD_REQUEST));
    }
}
