<?php

namespace Modules\Router;

use Laminas\Diactoros\Response\JsonResponse;
use Modules\Router\Exceptions\RequestNotMatchedException;

class Router
{
    /** @var Route[] */
    private array $routes = [];

    public function route(Route $route): static
    {
        $this->routes[] = $route;

        return $this;
    }

    /** @return Route[] */
    public function all(): array
    {
        return $this->routes;
    }

    public function match(Method|string $method, string $uriPath): Route
    {
        if (is_string($method)) {
            $method = Method::from($method);
        }

        foreach ($this->routes as $route) {
            if ($route->match($method, $uriPath)) {
                return $route;
            }
        }

        throw new RequestNotMatchedException('Route not found');
    }
}