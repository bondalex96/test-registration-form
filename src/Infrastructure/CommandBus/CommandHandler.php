<?php

namespace App\Infrastructure\CommandBus;


interface CommandHandler
{
    public function handle(Command $command);
}
