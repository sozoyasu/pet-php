<?php

use App\Support\View\ViewRender;

/** @var ViewRender $this */
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? '' ?></title>

    <?= $this->vite->asset('resources/css/app.css') ?>
</head>
<body>

    <div id="app"></div>
    <?= $this->vite->asset('resources/js/app.js') ?>
</body>
</html>