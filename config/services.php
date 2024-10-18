<?php

use App\Support\Application\MiddlewareHandleResolver;
use App\Support\Config;
use App\Support\Container\Container;
use App\Support\Middleware\HandleResolver;

return [
    HandleResolver::class => fn(Container $container) => new MiddlewareHandleResolver($container),
    Config::class => fn() => new Config(require(__DIR__.'/../config/parameters.php')),
];