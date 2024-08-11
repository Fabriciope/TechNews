<?php

namespace Src\Core\Middleware;

use Src\Core\Request\Request;

interface MiddlewareInterface
{
    public function handle(Request $request, callable $next): void;
}
