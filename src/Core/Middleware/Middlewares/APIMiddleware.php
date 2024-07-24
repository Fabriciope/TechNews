<?php

namespace Src\Core\Middleware\Middlewares;

use Src\Core\Middleware\MiddlewareInterface;
use Src\Http\Requests\Request;

class APIMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): void
    {
    }
}
