<?php

namespace App\Middleware;

use App\Support\Application\RouteHandleResolver;
use App\Support\Router\Router;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteMiddleware implements MiddlewareInterface
{
    private Router $router;
    private RouteHandleResolver $resolver;

    public function __construct(Router $router, RouteHandleResolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
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

            return $this->resolver->resolve($route->getHandler(), $request);
        } catch (Exception $exception) {}

        return $handler->handle($request);
    }
}