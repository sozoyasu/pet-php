<?php

namespace App\View\Extensions;

class HelloWorldViewExtension
{
    public function alternative(): string
    {
        return 'Alternative Hello';
    }

    public function __invoke(string $as = ''): string
    {
        return 'Hello World!' . $as;
    }
}