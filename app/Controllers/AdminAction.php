<?php

namespace App\Controllers;

use App\Support\Http\Response;
use App\Support\Http\StatusCode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new Response('Вы залогинились');
    }
}