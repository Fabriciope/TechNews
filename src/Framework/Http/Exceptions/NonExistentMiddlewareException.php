<?php

namespace Src\Framework\Http\Exceptions;

use Src\Framework\Exceptions\NonExistentClassException;

class NonExistentMiddlewareException extends NonExistentClassException
{
    public function __construct(string $middleware, string $message = '')
    {
        parent::__construct($middleware, $message);
    }

    public function getMiddleware(): string
    {
        return parent::getClass();
    }
}
