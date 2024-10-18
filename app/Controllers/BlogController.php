<?php

namespace App\Controllers;

use App\Support\Http\JsonResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            ['id' => 1, 'title' => 'Я тайтл 1'],
            ['id' => 2, 'title' => 'Я тайтл 2'],
        ]);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['id' => 1, 'title' => 'Я тайтл 1']);
    }
}