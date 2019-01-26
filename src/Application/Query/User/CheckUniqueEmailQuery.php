<?php

namespace App\Application\Query\User;


use App\Infrastructure\QueryBus\Query;

class CheckUniqueEmailQuery implements Query
{
    public $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
