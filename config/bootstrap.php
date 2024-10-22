<?php

use App\Support\Application\MiddlewareHandleResolver;
use App\Support\Config;
use App\Support\Container\Container;
use App\Support\Middleware\HandleResolver;
use App\Support\View\ViewRender;
use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;

require __DIR__.'/../vendor/autoload.php';

$env = Dotenv::createImmutable(dirname(__DIR__));
$env->load();

$container = new Container();

$container->set(HandleResolver::class, fn(Container $container) => new MiddlewareHandleResolver($container));
$container->set(Config::class, fn() => new Config(require('config.php')));
$container->set(ViewRender::class, function(ContainerInterface $container) {
    return new ViewRender($container->get(Config::class)->get('view.templates_patch'));
});