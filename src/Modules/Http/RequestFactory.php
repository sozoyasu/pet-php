<?php

namespace Modules\Http;

class RequestFactory
{
    public static function fromGlobals(): Request
    {
        $request = new Request(
            serverParams: $_SERVER,
            queryParams: $_GET,
            bodyParams: $_POST,
            body: new Stream('php://input'),
            cookies: $_COOKIE
        );

        foreach (getallheaders() as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        $serverUriParsed = explode('?', $_SERVER['REQUEST_URI']);

        $uri = new Uri();
        $uri = $uri->withScheme($_SERVER['REQUEST_SCHEME'] ?? '');
        $uri = $uri->withHost($_SERVER['SERVER_NAME'] ?? '');
        $uri = $uri->withPort($_SERVER['SERVER_PORT'] ?? '');
        $uri = $uri->withPath($serverUriParsed[0] ?? '');
        $uri = $uri->withQuery($_SERVER['QUERY_STRING'] ?? '');

        $request = $request->withMethod($_SERVER['REQUEST_METHOD'] ?? '');
        $request = $request->withRequestTarget($uri->getPath());
        $request = $request->withUri($uri);

        return $request;
    }
}