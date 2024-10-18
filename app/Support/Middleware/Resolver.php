<?php

namespace App\Support\Middleware;

use Exception;
use InvalidArgumentException;
use Psr\Http\Server\MiddlewareInterface;

class Resolver
{
    public function resolve($content)
    {
        if (is_string($content) && class_exists($content)) {
            $content = new $content();
        }

        if (is_callable($content)) {
            $content = $content();
        }

        if (!is_a($content, MiddlewareInterface::class)) {
            throw new InvalidArgumentException("Unsupported Middleware implementation");
        }

        return $content;
    }
}