<?php

namespace App\Infrastructure\EventListener\ExceptionsHandling;

use App\Infrastructure\Form\FormValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class FormValidationExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof FormValidationException) {
            return;
        }

        $event->setResponse(new JsonResponse(['errors' => $exception->getErrorsMessages()], Response::HTTP_BAD_REQUEST));
    }
}
