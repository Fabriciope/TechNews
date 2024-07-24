<?php

namespace Src\Core\Routing\Exceptions;

use Src\Exceptions\NonExistentClassException;

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
