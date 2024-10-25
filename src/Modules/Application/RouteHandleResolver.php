<?php

namespace Modules\Application;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouteHandleResolver
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function resolve($handler, ServerRequestInterface $request): mixed
    {
        if (is_string($handler) && class_exists($handler)) {
            $action = $this->container->get($handler);

            return $action($request);
        }

        if (is_array($handler) && class_exists($handler[0]) && method_exists($handler[0], $handler[1])) {
            $controller = $this->container->get($handler[0]);
            $method = $handler[1];

            return $controller->$method($request);
        }

        if (is_a($handler, ResponseInterface::class)) {
            return $handler;
        }

        if (is_callable($handler)) {
            return $handler($request);
        }

        throw new InvalidArgumentException('Invalid handler provided for route');
    }
}