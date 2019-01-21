<?php

namespace App\Infrastructure\Controller;


use App\Application\UseCase\Interactor;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
}
