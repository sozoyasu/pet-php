<?php

use App\Controllers\AboutAction;
use App\Controllers\AdminAction;
use App\Controllers\Blog\BlogPostAction;
use App\Controllers\Blog\BlogPostsAction;
use App\Controllers\HomeAction;
use App\Support\Http\RequestFactory;
use App\Support\Http\Response;
use App\Support\Http\ResponseSender;
use App\Support\Router\Exceptions\RequestNotMatchedException;
use App\Support\Router\Route;
use App\Support\Router\Router;
use Psr\Http\Message\ResponseInterface;

require __DIR__.'/../vendor/autoload.php';

$request = RequestFactory::fromGlobals();

$router = new Router();
$router->route(Route::create('/about', AboutAction::class)->withName('about'));
$router->route(Route::create('/blog/{id}', BlogPostAction::class)->withName('blog.post'));
$router->route(Route::create('/blog', BlogPostsAction::class)->withName('blog'));
$router->route(Route::create('/admin', AdminAction::class)->withName('blog'));
$router->route(Route::create('/', HomeAction::class)->withName('home'));

try {
    $route = $router->match($request->getMethod(), $request->getUri()->getPath());

    if (!empty($route->getAttributes())) {
        foreach ($route->getAttributes() as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }
    }

    $handler = $route->getHandler();

    if (is_string($handler)) {
        $handler = new $handler();
        $response = $handler($request);
    } elseif (is_a($handler, ResponseInterface::class)) {
        $response = $handler;
    } elseif (is_callable($handler) || is_object($handler)) {
        $response = $handler($request);
    } else {
        throw new RuntimeException('Unsupported handler');
    }

} catch (RequestNotMatchedException $exception) {
    $response = new Response('', 404);
}

$response->withHeader('X-Developer', 'sozoyasu');

(new ResponseSender())->send($response);