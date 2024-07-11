<?php

namespace Src\Http\Middleware;

use Src\Http\Requests\Request;

interface MiddlewareInterface
{
    public function handle(Request $request, \Closure $next);
}
