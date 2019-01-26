<?php

namespace App\Infrastructure\CommandBus;


use Symfony\Component\Validator\Validation;

class ValidationCommandBusProxy implements CommandBus
{
    private $next;
    private $validator;

    public function __construct(CommandBus $commandBus, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->next = $commandBus;
    }

    public function execute(Command $command): ?object
    {
        $errors = $this->validator->validate($command);
        if (!$errors) {
            return $this->next->execute($command);
        }
        throw new ValidationCommandException($errors);
    }
}
