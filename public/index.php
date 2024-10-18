<?php

use App\Controllers\AboutAction;
use App\Controllers\AdminAction;
use App\Controllers\Blog\BlogPostAction;
use App\Controllers\Blog\BlogPostsAction;
use App\Controllers\HomeAction;
use App\Middleware\ActionProfilerMiddleware;
use App\Middleware\DeveloperMiddleware;
use App\Middleware\NotFoundMiddleware;
use App\Middleware\RouteMiddleware;
use App\Support\Http\RequestFactory;
use App\Support\Http\ResponseSender;
use App\Support\Middleware\Pipeline;
use App\Support\Router\Route;
use App\Support\Router\Router;

require __DIR__.'/../vendor/autoload.php';

$request = RequestFactory::fromGlobals();

$router = new Router();
$router->route(Route::create('/about', AboutAction::class)->withName('about'));
$router->route(Route::create('/blog/{id}', BlogPostAction::class)->withName('blog.post'));
$router->route(Route::create('/blog', BlogPostsAction::class)->withName('blog'));
$router->route(Route::create('/admin', AdminAction::class)->withName('blog'));
$router->route(Route::create('/', HomeAction::class)->withName('home'));

$pipeline = new Pipeline();
$pipeline->pipe( ActionProfilerMiddleware::class);
$pipeline->pipe( DeveloperMiddleware::class);
$pipeline->pipe( new RouteMiddleware($router));
$pipeline->pipe( NotFoundMiddleware::class);

$response = $pipeline->handle($request);

(new ResponseSender())->send($response);