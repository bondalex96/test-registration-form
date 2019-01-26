<?php

namespace App\Infrastructure\EventListener\ExceptionsHandling;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class MethodNotAllowedHttpExceptionListener
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof MethodNotAllowedHttpException) {
            return;
        }

        $event->setResponse(new JsonResponse([
            'errors' => $exception->getMessage()
        ], Response::HTTP_METHOD_NOT_ALLOWED));
    }
}
