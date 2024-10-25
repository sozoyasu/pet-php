<?php

namespace App\Controllers;

use Modules\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new Response('Вы залогинились');
    }
}