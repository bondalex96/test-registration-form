<?php

namespace App\Application\Query\User;


use App\Infrastructure\QueryBus\Query;

class CheckUniqueNickQuery implements Query
{
    public $nick;

    public function __construct(string $nick)
    {
        $this->nick = $nick;
    }
}
