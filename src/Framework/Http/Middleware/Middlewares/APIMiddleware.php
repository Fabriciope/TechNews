<?php

namespace Src\Framework\Http\Middleware\Middlewares;

use Src\Framework\Http\Middleware\MiddlewareInterface;
use Src\Framework\Http\Request\Request;
use Src\Framework\Http\Response;

class APIMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): void
    {
        $requestPath = $request->path;
        $acceptMimes = Request::getServerVar('HTTP_ACCEPT');
        if (!str_starts_with($requestPath, '/api') or !str_contains($acceptMimes, 'application/json')) {
            Response::setContentType('text/html');
            renderErrorViewAndExit(
                title: 'erro na requisição',
                message: 'Invalid api request',
                code: 400,
            );
            return;
        }

        $next();
    }
}
