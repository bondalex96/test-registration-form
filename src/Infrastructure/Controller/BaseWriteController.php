<?php

namespace App\Infrastructure\Controller;


use App\Application\UseCase\Interactor;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseWriteController extends AbstractController
{
    private $formName;
    protected $interactor;
    private $logger;

    public function __construct(Interactor $interactor, LoggerInterface $logger, string $formName)
    {
        $this->formName = $formName;
        $this->interactor = $interactor;
        $this->logger = $logger;
    }

    abstract protected function getInteractor();

    protected function executeAction(Request $request, callable $action): Response
    {
        $form = $this->createForm($this->formName);
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                return $action($form->getData());

            } catch (\DomainException $exception) {
                return $this->json([
                    'errors' => [$exception->getMessage()]
                ], Response::HTTP_BAD_REQUEST);

            } catch (\Throwable $exception) {
                $this->handleInternalException($exception);
            }
        }

        return $this->json(
            ['errors' => $this->formatFormErrors($form)]
        );
    }

    private function formatFormErrors(FormInterface $form)
    {
        $formErrors = [];
        foreach ($form->getErrors(true) as $error) {
            $formErrors[] = $error->getMessage();
        }

        return $formErrors;
    }

    private function handleInternalException(\Throwable $exception)
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
