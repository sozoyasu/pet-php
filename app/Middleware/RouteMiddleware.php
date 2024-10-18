<?php

namespace App\Middleware;

use App\Support\Http\JsonResponse;
use App\Support\Router\Route;
use App\Support\Router\Router;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

class RouteMiddleware implements MiddlewareInterface
{
    private Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $route = $this->router->match($request->getMethod(), $request->getUri()->getPath());

            if (!empty($route->getAttributes())) {
                foreach ($route->getAttributes() as $key => $value) {
                    $request = $request->withAttribute($key, $value);
                }
            }

            $routeHandler = $route->getHandler();

            if (is_string($routeHandler)) {
                $routeHandler = new $routeHandler();
                return $routeHandler($request);
            } elseif (is_a($routeHandler, ResponseInterface::class)) {
                return $routeHandler;
            } elseif (is_callable($routeHandler) || is_object($routeHandler)) {
                return $routeHandler($request);
            }
        } catch (Exception $exception) {

        }

        return $handler->handle($request);
    }
}