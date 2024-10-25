<?php

namespace App\Controllers;

use App\Support\View\ViewRender;
use Modules\Http\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeAction
{
    private ViewRender $view;

    public function __construct(ViewRender $view)
    {
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->view->render('index', [
            'title' => 'Главная страница',
        ]));
    }
}