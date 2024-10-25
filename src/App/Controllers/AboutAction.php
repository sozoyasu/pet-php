<?php

namespace App\Controllers;

use Modules\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AboutAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new Response('О сайте');
    }
}