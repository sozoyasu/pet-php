<?php

namespace App\Controllers;

use App\Support\Http\Response;
use App\Support\Http\StatusCode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if ($username === 'useruse' || $password === '123') {
            return new Response('Вы залогинились');
        }

        return (new Response('Требуется авторизация', StatusCode::Code401))->withHeader('WWW-Authenticate', 'Basic realm=Restricted Area');
    }
}