<?php

namespace Modules\Middleware;

use Modules\Middleware\Exception\QueueIsEmptiedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

class Handler implements RequestHandlerInterface
{
    private SplQueue $pipes;
    private HandleResolver $resolver;

    public function __construct(SplQueue $pipes, HandleResolver $resolver)
    {
        $this->pipes = $pipes;
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return $this->handle($request);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->pipes->isEmpty()) {
            throw new QueueIsEmptiedException('Queue is empty');
        }

        /** @var MiddlewareInterface $current */
        $current = $this->resolver->resolve($this->pipes->dequeue());

        return $current->process($request, $this);
    }
}