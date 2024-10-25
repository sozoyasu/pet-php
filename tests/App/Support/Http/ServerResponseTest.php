<?php

namespace App\Support\Http;

use Modules\Http\Response;
use Modules\Http\StatusCode;
use PHPUnit\Framework\TestCase;

class ServerResponseTest extends TestCase
{
    public function testStatusCode(): void
    {
        $response = new Response('', $status = StatusCode::from(403));

        self::assertEquals($status->value, $response->getStatusCode());
    }

//    public function testReasonPhrase(): void
//    {
//        $response = new ServerResponse('', $status = StatusCode::from(403));
//
//        self::assertEquals($status->getPhrase(), $response->getReasonPhrase());
//    }
//
//    public function testBody(): void
//    {
//        $response = new ServerResponse($body = 'test');
//
//        self::assertEquals($body, $response->getBody());
//    }
//
//    public function testHeaders(): void
//    {
//        $response = new ServerResponse('');
//        $response->withHeader($headerKey = 'key', $headerValue = 'value');
//
//        $headers = $response->getHeaders();
//
//        self::assertArrayHasKey($headerKey, $headers);
//        self::assertNotEmpty($headers[$headerKey]);
//        self::assertEquals($headers[$headerKey], $headerValue);
//    }
}