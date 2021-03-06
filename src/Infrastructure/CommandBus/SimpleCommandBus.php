<?php

namespace App\Infrastructure\CommandBus;

use Psr\Container\ContainerInterface;

class SimpleCommandBus implements CommandBus
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function execute(Command $command): ?object
    {
        return $this->resolveHandler($command)->handle($command);
    }

    private function resolveHandler(Command $command): CommandHandler
    {
        $handlerName = substr(get_class($command), 0, -7) . 'Handler';
        $handler = $this->container->get($handlerName);
        if (!$handler instanceof CommandHandler) {
            throw new \LogicException('Handler should be instance of ' . CommandHandler::class);
        }

        return $this->container->get($handlerName);
    }
}
