<?php

namespace App\Support\Container;

use App\Support\Container\Exceptions\NotFoundException;
use PHPUnit\Framework\TestCase;
use stdClass;
use function PHPUnit\Framework\assertEquals;

class ContainerTest extends TestCase
{
    public function testAdd()
    {
        $container = new Container();

        $container->set('int', $value1 = 1);
        self::assertEquals($value1, $container->get('int'));

        $container->set('string', $value2 = 'string');
        self::assertEquals($value2, $container->get('string'));

        $container->set('array', $value3 = [1, 2, 3]);
        self::assertEquals($value3, $container->get('array'));

        $container->set('obj', $value4 = new stdClass());
        self::assertEquals($value4, $container->get('obj'));
    }

    public function testClosure()
    {
        $container = new Container();
        $container->set('closure', function () {
            return new stdClass();
        });

        self::assertInstanceOf(stdClass::class, $container->get('closure'));
    }

    public function testInjectInsideClosure()
    {
        $container = new Container();
        $container->set('config.param', $value = '33');
        $container->set('object', function () use ($value) {
            $std = new stdClass();
            $std->param = $value;

            return $std;
        });

        self::assertObjectHasProperty('param', $container->get('object'));
        self::assertEquals($value, $container->get('object')->param);
    }
    
    public function testCacheInstance()
    {
        $container = new Container();
        $container->set('obj', function () {
            return new stdClass();
        });

        $value1 = $container->get('obj');
        $value2 = $container->get('obj');

        assert($value1 === $value2);
    }

    public function testKeyNotFound()
    {
        self::expectException(NotFoundException::class);

        $container = new Container();
        $container->get('id');
    }
}