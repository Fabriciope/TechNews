<?php

namespace Src\Http\Middlewares;

use Src\Framework\Http\Middleware\MiddlewareInterface;
use Src\Framework\Http\Request\Request;

class Authenticate implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): void
    {
        var_dump('auth', $request);
        $next();
    }
}
