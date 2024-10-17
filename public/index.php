<?php

use App\Support\Http\RequestFactory;
use App\Support\Http\Response;
use App\Support\Http\ResponseSender;
use App\Support\Router\Exceptions\RequestNotMatchedException;
use App\Support\Router\Route;
use App\Support\Router\Router;

require __DIR__.'/../vendor/autoload.php';

$request = RequestFactory::fromGlobals();

$router = new Router();
$router->route(Route::create('/about', new Response('О проекте')));
$router->route(Route::create('/blog', new Response('Посты')));
$router->route(Route::create('/', new Response('Главная страница')));

try {
    $route = $router->match($request->getMethod(), $request->getUri()->getPath());
    $response = $route->getHandler();
} catch (RequestNotMatchedException $exception) {
    $response = new Response('', 404);
}

$response->withHeader('X-Developer', 'sozoyasu');

(new ResponseSender())->send($response);