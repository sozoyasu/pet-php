<?php

use App\Support\Application\MiddlewareHandleResolver;
use App\Support\Config;
use App\Support\Container\Container;
use App\Support\Middleware\HandleResolver;
use App\Support\View\ViewRender;
use Psr\Container\ContainerInterface;

return [
    HandleResolver::class => fn(Container $container) => new MiddlewareHandleResolver($container),
    Config::class => fn() => new Config(require(__DIR__.'/../config/parameters.php')),

    ViewRender::class => function(ContainerInterface $container) {
        return new ViewRender($container->get(Config::class)->get('view.templates_patch'));
    },
];