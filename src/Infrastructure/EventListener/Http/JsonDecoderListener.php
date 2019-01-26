<?php

namespace App\Infrastructure\EventListener\Http;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class JsonDecoderListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * JsonDecoderListener constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($request->headers->has('Content-Type')) {
            /** @var string $contentType */
            $contentType = $request->headers->get('Content-Type', '');

            if (substr_count($contentType, 'application/json') > 0) {
                /** @var string $requestContent */
                $requestContent = $request->getContent();
                $data = json_decode($requestContent, true);

                if (is_array($data)) {
                    $request->request = new ParameterBag($data);
                    $this->logger->notice('Request Body', $data);
                }
            }
        }
    }
}