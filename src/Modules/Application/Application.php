<?php

namespace Modules\Application;

use Modules\Middleware\Pipeline;
use Modules\Router\Method;
use Modules\Router\Route;
use Modules\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class Application
{
    private Router $router;
    private Pipeline $pipeline;
    private array $middlewares = [];

    public function __construct(Pipeline $pipeline, Router $router)
    {
        $this->router = $router;
        $this->pipeline = $pipeline;
    }

    /**
     * Добавляет посредника в цепочку
     *
     * @param string|callable|MiddlewareInterface $middleware
     * @param callable|null $condition
     * @return void
     */
    public function middleware(string|callable|MiddlewareInterface $middleware, callable $condition = null): void
    {
        $this->middlewares[] = [$middleware, $condition];
    }

    /**
     * Добавляет сырой маршрут через объект роутера (надо бы исправить)
     * @param Route $route
     * @return void
     */
    public function route(Route $route): void
    {
        $this->router->route($route);
    }

    /**
     * Новый GET маршрут
     * @param string $pattern
     * @param mixed $handler
     * @param string|null $name
     * @return void
     */
    public function get(string $pattern, mixed $handler, string $name = null): void
    {
        $this->router->route(new Route($pattern, $handler, Method::GET, $name));
    }

    /**
     * Новый POST маршрут
     *
     * @param string $pattern
     * @param mixed $handler
     * @param string|null $name
     * @return void
     */
    public function post(string $pattern, mixed $handler, string $name = null): void
    {
        $this->router->route(new Route($pattern, $handler, Method::POST, $name));
    }

    /**
     * Запускает цепочку пайплайна
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        // Записываем посредников в трубопровод, при этом проверяя условие
        foreach ($this->middlewares as $middleware) {
            if (is_callable($middleware[1]) && $middleware[1]($request) || empty($middleware[1])) {
                $this->pipeline->pipe($middleware[0]);
            }
        }

        return $this->pipeline->handle($request);
    }
}