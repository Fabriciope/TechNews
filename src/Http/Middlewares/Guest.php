<?php

namespace Src\Http\Middlewares;

use Fabriciope\Router\Middleware\MiddlewareInterface;
use Fabriciope\Router\Request\Request;

class Guest implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): void
    {
        //TODO: add logic
        $next();
    }
}
