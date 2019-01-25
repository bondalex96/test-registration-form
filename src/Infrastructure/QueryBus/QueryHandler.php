<?php

namespace App\Infrastructure\QueryBus;


interface QueryHandler
{
    public function handle(Query $query): object;
}
