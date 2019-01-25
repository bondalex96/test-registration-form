<?php

namespace App\Infrastructure\CommandBus;


interface ValidatorInterface
{
    public function validate($value);
}
