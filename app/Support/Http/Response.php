<?php

namespace App\Support\Http;

use App\Support\Http\Traits\MessageTrait;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{
    use MessageTrait;

    private StreamInterface $body;
    private StatusCode $status;

    public function __construct(string|StreamInterface $body, int|StatusCode $status = StatusCode::Code200)
    {
        if (is_string($body)) {
            $stream = new Stream('php://temp', 'wb+');
            $stream->write($body);
            $stream->rewind();
            $body = $stream;
        }

        if (is_int($status)) {
            $status = StatusCode::from($status);
        }

        $this->body = $body;
        $this->status = $status;
    }

    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    public function withBody(string|StreamInterface $body): MessageInterface
    {
        $new = clone $this;

        if (is_string($body)) {
            $body = StreamFactory::fromString($body);
        }

        $new->body = $body;

        return $new;
    }

    public function getStatusCode(): int
    {
        return $this->status->value;
    }

    public function getReasonPhrase(): string
    {
        return $this->status->getPhrase();
    }

    public function withStatus(int|StatusCode $code, string $reasonPhrase = ''): ResponseInterface
    {
        $new = clone $this;

        if (is_int($code)) {
            $code = StatusCode::from($code);
        }

        $new->status = $code;

        return $new;
    }
}