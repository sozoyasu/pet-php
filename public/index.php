<?php

/** @var ContainerInterface $container */
/** @var Application $app */

use App\Support\Application\Application;
use App\Support\Http\RequestFactory;
use App\Support\Http\ResponseSender;
use App\Support\Migration\Migrator;
use Psr\Container\ContainerInterface;

require __DIR__.'/../config/bootstrap.php';

$app = $container->get(Application::class);

$env = parse_ini_file(__DIR__.'/../.env');

dump($_ENV);
dump(getenv('MYSQL_ROOT_PASSWORD', true));
dump(getenv('MYSQL_USER', true));

exit();

//$migrator = new Migrator(root_path('db/migrations'));
//
//exit();

require(__DIR__.'/../config/routes.php');
require(__DIR__.'/../config/middleware.php');

$request = RequestFactory::fromGlobals();
$response = $app->run($request);

(new ResponseSender())->send($response);