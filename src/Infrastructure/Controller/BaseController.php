<?php

namespace App\Infrastructure\Controller;


use App\Application\UseCase\Interactor;
use App\Infrastructure\Form\FormValidationInteractorProxy;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends AbstractController
{
    private $interactor;
    private $logger;

    public function __construct(LoggerInterface $logger, Interactor $interactor)
    {
        $this->logger = $logger;
        $this->interactor = $interactor;
    }

    protected function getInteractor(): Interactor
    {
        return $this->interactor;
    }

    protected function handleInternalException(\Throwable $exception)
    {
        $this->logger->error('Internal error', [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
        ]);

        return $this->json([
            'errors' => ['Unexpected internal error']
        ], Response::HTTP_BAD_REQUEST);
    }
}
