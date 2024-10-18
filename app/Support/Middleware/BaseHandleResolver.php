<?php

namespace App\Support\Middleware;

use Exception;
use InvalidArgumentException;
use Psr\Http\Server\MiddlewareInterface;

class BaseHandleResolver implements HandleResolver
{
    public function resolve($handler): mixed
    {
        if (is_string($handler) && class_exists($handler)) {
            $handler = new $handler();
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