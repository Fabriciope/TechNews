<?php

namespace Src\Framework\Http\Middleware;

use Src\Framework\Http\Request\Request;

interface MiddlewareInterface
{
    public function handle(Request $request, callable $next): void;
}
