<?php

namespace App\Infrastructure\QueryBus;

use Psr\Container\ContainerInterface;

class SimpleQueryBus implements QueryBus
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function execute(Query $query): object
    {
        return $this->resolveHandler($query)->handle($query);
    }

    private function resolveHandler(Query $query): QueryHandler
    {
        $handlerName = substr(get_class($query), 0, -5) . 'Handler';
        $handler = $this->container->get($handlerName);
        if (!$handler instanceof QueryHandler) {
            throw new \LogicException('Handler should be instance of ' . QueryHandler::class);
        }
        return $handler;
    }
}
