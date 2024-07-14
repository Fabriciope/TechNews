<?php

namespace Src\Http\Middlewares;

use Src\Core\Middleware\MiddlewareInterface;
use Src\Http\Requests\Request;

class Guest implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): void
    {
        var_dump('guest', $request);
        $next();
    }
}
