<?php

namespace App\Middleware;

use Modules\Config;
use Modules\Http\Response;
use Modules\Http\StatusCode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasicAuthMiddleware implements MiddlewareInterface
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if ($username === $this->config->get('auth.username') || $password === $this->config->get('auth.password')) {
            return $handler->handle($request);
        }

        return (new Response('Требуется авторизация', StatusCode::Code401))->withHeader('WWW-Authenticate', 'Basic realm=Restricted Area');
    }
}