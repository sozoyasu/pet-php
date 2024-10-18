<?php

/** @var Application $app */

use App\Middleware\ActionProfilerMiddleware;
use App\Middleware\BasicAuthMiddleware;
use App\Middleware\DeveloperMiddleware;
use App\Middleware\NotFoundMiddleware;
use App\Middleware\RouteMiddleware;
use App\Support\Application\Application;
use Psr\Http\Message\ServerRequestInterface;

$app->middleware(ActionProfilerMiddleware::class);
$app->middleware(DeveloperMiddleware::class);
$app->middleware(BasicAuthMiddleware::class, fn(ServerRequestInterface $request) => str_starts_with($request->getUri()->getPath(), '/admin'));
$app->middleware(RouteMiddleware::class);
$app->middleware(NotFoundMiddleware::class);