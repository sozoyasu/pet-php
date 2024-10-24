<?php

namespace App\Controllers;

use App\Entities\Blog\Post;
use App\Repositories\Blog\PostsRepository;
use App\Support\Http\HtmlResponse;
use App\Support\Http\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController
{
    private PostsRepository $posts;

    public function __construct(PostsRepository $posts)
    {
        $this->posts = $posts;
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
//        $post = new Post();
//        $post->title = 'Blog Post';
//        $post->annotation = 'Тут краткое содержание';
//        $post->content = '324';

//        $savedPost = $this->posts->create($post);

//        dump($post);
//        dump($savedPost);

        return new HtmlResponse('123');
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['id' => 1, 'title' => 'Я тайтл 1']);
    }
}