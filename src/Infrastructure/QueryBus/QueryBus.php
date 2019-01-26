<?php

namespace App\Infrastructure\QueryBus;


interface QueryBus
{
    public function execute(Query $query): object;
}
