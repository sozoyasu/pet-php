<?php

/** @var ContainerInterface $container */
/** @var \Modules\Application\Application $app */

use Modules\Application\Application;
use Modules\Http\RequestFactory;
use Modules\Http\ResponseSender;
use Psr\Container\ContainerInterface;

require __DIR__.'/../config/bootstrap.php';

$app = $container->get(Application::class);

require(__DIR__.'/../config/routes.php');
require(__DIR__.'/../config/middleware.php');

$request = RequestFactory::fromGlobals();
$response = $app->run($request);

(new ResponseSender())->send($response);