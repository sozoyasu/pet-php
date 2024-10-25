<?php

namespace Modules\Http;

use Psr\Http\Message\StreamInterface;

class JsonResponse extends Response implements \JsonSerializable
{
    public function __construct(array|string|StreamInterface $body, StatusCode|int $status = StatusCode::Code200)
    {
        if (is_string($body)) {
            $body = json_decode($body, true);
        }

        $body = StreamFactory::fromString(json_encode($body, JSON_UNESCAPED_SLASHES));

        parent::__construct(
            body: $body,
            status: $status,
            headers: ['Content-Type' => 'application/json; charset=utf-8'],
        );
    }

    public function jsonSerialize(): mixed
    {
        return (string)$this->getBody();
    }
}