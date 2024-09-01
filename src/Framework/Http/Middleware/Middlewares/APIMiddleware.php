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
            $this->setResponseHeaders();
            renderErrorViewAndExit(
                title: 'erro na requisição',
                message: 'Invalid api request' . $acceptMimes,
                code: 400,
            );
        }

        $next();
    }

    /**
     * @return void
     */
    public function setResponseHeaders(): void
    {
        Response::setContentType('text/html');
        Response::setStatusCode(400, 'Invalid api request');
    }
}
