<?php

namespace App\Infrastructure\EventListener\ExceptionsHandling;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundHttpExceptionListener
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof NotFoundHttpException) {
            return;
        }

        $event->setResponse(new JsonResponse([
            'errors' => $exception->getMessage()
        ], Response::HTTP_NOT_FOUND));
    }
}
