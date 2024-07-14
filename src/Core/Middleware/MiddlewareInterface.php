<?php

namespace Src\Core\Middleware;

use Src\Http\Requests\Request;

interface MiddlewareInterface
{
    public function handle(Request $request, callable $next): void;
}
