<?php

namespace App\Support\Middleware;

use App\Support\Http\Response;
use App\Support\Middleware\Exception\QueueIsEmptiedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

class Handler implements RequestHandlerInterface
{
    private SplQueue $pipes;

    public function __construct(SplQueue $pipes)
    {
        $this->pipes = $pipes;
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

        $resolver = new Resolver();

        /** @var MiddlewareInterface $current */
        $current = $resolver->resolve($this->pipes->dequeue());

        return $current->process($request, $this);
    }
}