<?php

namespace App\Controllers;

use App\Entities\Blog\Post;
use App\Repositories\Blog\PostsRepository;
use App\Support\Http\HtmlResponse;
use App\Support\Http\JsonResponse;
use App\Support\View\ViewRender;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController
{
    private PostsRepository $posts;
    private ViewRender $view;

    public function __construct(PostsRepository $posts, ViewRender $view)
    {
        $this->posts = $posts;
        $this->view = $view;
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

        return new HtmlResponse($this->view->render('index'));
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['id' => 1, 'title' => 'Я тайтл 1']);
    }
}