<?php

namespace App\Infrastructure\EventListener\Http;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class PreflightRequestListener
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        $method  = $request->getRealMethod();

        if ('OPTIONS' == $method) {
            $response = new Response('Preflight response');
            $event->setResponse($response);
        }
    }
}