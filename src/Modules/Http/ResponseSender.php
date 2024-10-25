<?php

namespace Modules\Http;

use Psr\Http\Message\ResponseInterface;

class ResponseSender
{
    public function send(ResponseInterface $response): void
    {
        header('HTTP/'.$response->getProtocolVersion().' '.$response->getStatusCode().' '.$response->getReasonPhrase());

        foreach ($response->getHeaders() as $name => $values) {
            header($name.':'.$response->getHeaderLine($name));
        }

        echo $response->getBody();
    }
}