<?php

namespace App\Support\Application;

use App\Support\Middleware\HandleResolver;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareHandleResolver implements HandleResolver
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolve($handler): mixed
    {
        if (is_string($handler) && class_exists($handler)) {
            $handler = $this->container->get($handler);
        }

        if (is_callable($handler)) {
            $handler = $handler();
        }

        if (!is_a($handler, MiddlewareInterface::class)) {
            throw new InvalidArgumentException("Unsupported Middleware implementation");
        }

        return $handler;
    }
}