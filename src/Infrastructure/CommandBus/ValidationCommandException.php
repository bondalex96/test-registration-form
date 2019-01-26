<?php

namespace App\Infrastructure\CommandBus;


class ValidationCommandException extends \LogicException
{
    private $errors = [];

    public function __construct(array $errors)
    {
        array_map(function ($error) {
            $this->addError($error);
        }, $errors);
    }

    public function getErrorsMessages(): array
    {
        return $this->errors;
    }

    private function addError(string $error): void
    {
        array_push($this->errors, $error);
    }
}
