<?php

namespace Modules\Http;

use Psr\Http\Message\StreamInterface;

class HtmlResponse extends Response
{
    public function __construct(string|StreamInterface $body, StatusCode|int $status = StatusCode::Code200)
    {
        if (is_string($body)) {
            $body = StreamFactory::fromString($body);
        }

        parent::__construct(
            body: $body,
            status: $status,
            headers: ['Content-Type' => 'text/html; charset=UTF-8'],
        );
    }
}