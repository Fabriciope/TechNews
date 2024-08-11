<?php

namespace Src\Framework\Http\Exceptions;

use Src\Framework\Exceptions\NonExistentClassException;

class NonExistentControllerException extends NonExistentClassException
{
    public function __construct(string $controller, string $message = '')
    {
        parent::__construct($controller, $message);
    }

    public function getController(): string
    {
        return parent::getClass();
    }
}
