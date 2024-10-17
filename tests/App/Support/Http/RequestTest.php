<?php

namespace App\Support\Http;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testAddAttributes()
    {
        $request = new Request([], []);
        $request = $request->withAttribute($attKey1 = 'attr_key1', $attValue1 = 'value1');

        $this->assertEquals($request->getAttribute($attKey1), $attValue1);
    }
}