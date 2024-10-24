<?php
use App\View\Extensions\HelloWorldViewExtension;

/** @var HelloWorldViewExtension $helloWorld */
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? '' ?></title>

    <script type="module" src="http://localhost:3000/@vite/client"></script>
    <link rel="stylesheet" href="http://localhost:3000/resources/css/app.css">
</head>
<body>

    <div id="app"></div>
    <script type="module" src="http://localhost:3000/resources/js/app.js"></script>
</body>
</html>