<?php

use App\Support\Application\Application;
use App\Support\Container\Container;
use App\Support\Http\RequestFactory;
use App\Support\Http\ResponseSender;

require __DIR__.'/../vendor/autoload.php';

$container = new Container(require(__DIR__.'/../config/services.php'));

/** @var Application $app */
$app = $container->get(Application::class);

require(__DIR__.'/../config/routes.php');
require(__DIR__.'/../config/middleware.php');

$request = RequestFactory::fromGlobals();
$response = $app->run($request);

(new ResponseSender())->send($response);