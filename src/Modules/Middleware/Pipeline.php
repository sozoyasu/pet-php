<?php

namespace Modules\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use SplQueue;

class Pipeline
{
    private SplQueue $pipes;
    private HandleResolver $resolver;

    public function __construct(HandleResolver $resolver)
    {
        $this->pipes = new SplQueue();
        $this->resolver = $resolver;
    }

    public function pipe(MiddlewareInterface|string|callable $callback): static
    {
        $this->pipes->enqueue($callback);

        return $this;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $handler = new Handler($this->pipes, $this->resolver);

        return $handler->handle($request);
    }
}