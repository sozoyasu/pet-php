<?php

namespace App\View\Extensions;

class HelloWorldViewExtension
{
    public function __invoke(): string
    {
        return 'Hello World!';
    }
}