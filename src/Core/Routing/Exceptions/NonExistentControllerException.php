<?php

namespace Src\Core\Routing\Exceptions;

use Src\Exceptions\NonExistentClassException;

class NonExistentControllerException extends NonExistentClassException
{
    public function __construct(string $controller, string $message = '')
    {
        parent::__construct($message, $controller);
    }

    public function getController(): string
    {
        return parent::getClass();
    }
}
