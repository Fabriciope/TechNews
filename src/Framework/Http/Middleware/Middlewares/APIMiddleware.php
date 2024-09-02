<?php

namespace Src\Framework\Http\Middleware\Middlewares;

use Src\Framework\Http\Middleware\MiddlewareInterface;
use Src\Framework\Http\Request\Request;
use Src\Framework\Http\Response;

class APIMiddleware implements MiddlewareInterface
{
    /**
     * This middleware verifies if a request is a API request
     *
     * @param \Src\Framework\Http\Request\Request $request
     * @param callable $next
     * @return void
     */
    public function handle(Request $request, callable $next): void
    {
        if (Request::isAPIRequest()) {
            $next();
            return;
        }

        Response::setContentType('text/html');
        Response::setStatusCode(400, 'Invalid api request');

        renderErrorAndExit(
            title: 'Invalid Request',
            message: 'Invalid api request',
            code: 400,
        );
    }
}
