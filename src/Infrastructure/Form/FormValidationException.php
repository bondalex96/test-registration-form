<?php

namespace App\Infrastructure\Form;


use Symfony\Component\Form\FormInterface;

class FormValidationException extends \LogicException
{
    private $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    public function getErrorsMessages()
    {
        $formErrors = [];
        foreach ($this->form->getErrors(true) as $error) {
            $formErrors[] = $error->getMessage();
        }

        return $formErrors;
    }
}
