<?php

namespace Src\Http\Middlewares;

use Src\Framework\Http\Middleware\MiddlewareInterface;
use Src\Framework\Http\Request\Request;

class Authenticate implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): void
    {
        //TODO: add logic
        $next();
    }
}
