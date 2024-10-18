<?php

namespace App\Support\Middleware;

interface HandleResolver
{
    public function resolve($handler): mixed;
}