<?php

namespace Modules\Middleware;

interface HandleResolver
{
    public function resolve($handler): mixed;
}