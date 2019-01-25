<?php

namespace App\Infrastructure\CommandBus;


class ValidatorAdapter implements ValidatorInterface
{
    private $validator;

    public function __construct(\Symfony\Component\Validator\Validator\ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($value): array
    {
        $errors = $this->validator->validate($value);
        $errorsMessages = [];
        foreach ($errors as $error) {
            array_push($errorsMessages, $error->getMessage());
        }

        return $errorsMessages;
    }
}
