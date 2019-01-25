<?php

namespace App\Infrastructure\CommandBus;



interface CommandBus
{
    public function execute(Command $command): ?object;
}
