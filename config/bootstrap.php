<?php

use App\Support\Application\MiddlewareHandleResolver;
use App\Support\Config;
use App\Support\Container\Container;
use App\Support\Middleware\HandleResolver;
use App\Support\Migration\Migrator;
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

$container->set(PDO::class, function(ContainerInterface $container) {
    $config = $container->get(Config::class);

    return new PDO(
        "mysql:host={$config('db.host')};port={$config('db.port')};dbname={$config('db.database')};charset={$config('db.charset')}",
        $config('db.username'),
        $config('db.password'),
    );
});

$container->set(Migrator::class, function(ContainerInterface $container) {
    return new Migrator(root_path('db/migrations'), $container->get(PDO::class));
});