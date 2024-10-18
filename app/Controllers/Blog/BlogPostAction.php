<?php

namespace App\Controllers\Blog;

use App\Support\Http\JsonResponse;
use App\Support\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogPostAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            ['id' => 1, 'title' => 'Я тайтл 1'],
            ['id' => 2, 'title' => 'Я тайтл 2'],
        ]);
    }
}