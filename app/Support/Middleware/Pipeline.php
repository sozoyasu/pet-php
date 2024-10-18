<?php

namespace App\Support\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

class Pipeline
{
    private SplQueue $pipes;

    public function __construct()
    {
        $this->pipes = new SplQueue();
    }

    public function pipe(MiddlewareInterface|string|callable $callback): static
    {
        $this->pipes->enqueue($callback);

        return $this;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $handler = new Handler($this->pipes);

        return $handler->handle($request);
    }
}