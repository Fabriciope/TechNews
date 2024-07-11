<?php

namespace Src\Core\Routing\Exceptions;

use Src\Exceptions\NonExistentClassException;

class NonExistentMiddlewareException extends NonExistentClassException
{
    public function __construct(
        string $message = "",
        private string $middleware,
    ) {
        parent::__construct($message, $middleware);
    }

    public function getMiddleware(): string
    {
        return parent::getClass();
    }
}
