<?php

use App\View\Extensions\ViteViewExtension;
use Dotenv\Dotenv;
use Modules\Application\MiddlewareHandleResolver;
use Modules\Config;
use Modules\Container\Container;
use Modules\Middleware\HandleResolver;
use Modules\Migration\Migrator;
use App\Support\View\ViewRender;
use Psr\Container\ContainerInterface;

require __DIR__.'/../vendor/autoload.php';

$env = Dotenv::createImmutable(dirname(__DIR__));
$env->load();

$container = new Container();

$container->set(HandleResolver::class, fn(Container $container) => new MiddlewareHandleResolver($container));

$container->set(Config::class, fn() => new Config(require('config.php')));

$container->set(ViewRender::class, function(ContainerInterface $container) {
    /** @var Config $config */
    $config = $container->get(Config::class);
    $render = new ViewRender($config('view.templates_patch'));

    foreach ($config('view.extensions', []) as $name => $class) {
        $render->expand($name, fn() => $container->get($class));
    }

    $render->expand('vite', function () use ($config) {
        return new ViteViewExtension(
            isProduction: $config('app.is_production', false),
            viteHost: env('VITE_HOST'),
            vitePort: env('VITE_PORT'),
            viteHttps: env('VITE_HTTP') == 'https',
            productionPathReplaces: [
                'resources' => 'assets'
            ],
        );
    });

    return $render;
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