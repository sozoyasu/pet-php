<?php

/** @var Application $app */

use App\Controllers\AboutAction;
use App\Controllers\AdminAction;
use App\Controllers\BlogController;
use App\Controllers\HomeAction;
use App\Support\Application\Application;

$app->get('/admin', AdminAction::class, 'admin.index');
$app->get('/about', AboutAction::class, 'blog.post');
$app->get('/blog/{id}', [BlogController::class, 'post'], 'blog.post');
$app->get('/blog', [BlogController::class, 'index'], 'blog');
$app->get('/', HomeAction::class, 'home');