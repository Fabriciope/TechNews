<?php

namespace Src\Http\Middlewares;

use Fabriciope\Router\Middleware\MiddlewareInterface;
use Fabriciope\Router\Request\Request;

class Authenticate implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): void
    {
        //TODO: add logic
        $next();
    }
}
