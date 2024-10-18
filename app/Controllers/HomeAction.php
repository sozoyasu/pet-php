<?php

namespace App\Controllers;

use App\Support\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new Response('Главная страница');
    }
}