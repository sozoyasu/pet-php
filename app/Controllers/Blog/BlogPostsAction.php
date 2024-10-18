<?php

namespace App\Controllers\Blog;

use App\Support\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogPostsAction
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new Response('Посты');
    }
}