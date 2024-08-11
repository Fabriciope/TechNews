<?php

namespace Src\Http\Middlewares;

use Src\Core\Middleware\MiddlewareInterface;
use Src\Core\Request\Request;

class Authenticate implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): void
    {
        var_dump('auth', $request);
        $next();
    }
}
