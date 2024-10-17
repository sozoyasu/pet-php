<?php

namespace App\Support\Http;

use Psr\Http\Message\StreamInterface;

class StreamFactory
{
    public static function fromString(string $content): StreamInterface
    {
        $stream = new Stream('php://temp', 'wb+');
        $stream->write($content);
        $stream->rewind();

        return $stream;
    }
}