<?php

namespace Modules\Router;

use Psr\Http\Message\ServerRequestInterface;

interface HandleResolver
{
    public function resolve($handler, ServerRequestInterface $request): mixed;
}