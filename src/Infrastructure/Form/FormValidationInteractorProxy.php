<?php

namespace App\Infrastructure\Form;


use App\Application\UseCase\Interactor;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FormValidationInteractorProxy implements Interactor
{
    private $next;
    private $form;
    private $httpRequest;

    public function __construct(RequestStack $requestStack, FormFactoryInterface $formFactory, Interactor $interactor, string $formName)
    {
        $this->httpRequest = $requestStack->getCurrentRequest();
        $this->next = $interactor;
        $this->form = $formFactory->create($formName);
    }

    public function execute(...$args)
    {
        $params = $args;

        $this->form->submit($this->httpRequest->request->all());

        if ($this->form->isSubmitted() && $this->form->isValid()) {

            array_push($params, $this->form->getData());

            return call_user_func_array([$this->next, "execute"], $params);
        }

        throw new FormValidationException($this->form);
    }
}
