<?php

use App\Support\Http\RequestFactory;
use App\Support\Http\Response;
use App\Support\Http\ResponseSender;

require __DIR__.'/../vendor/autoload.php';

$request = RequestFactory::fromGlobals();

if ($request->getQueryParams() !== []) {
    $response = new Response('With parameters', 404);
} else {
    $response = new Response('Noted');
}

$response->withHeader('X-Developer', 'sozoyasu');

(new ResponseSender())->send($response);