<?php

namespace Src\Core\Routing\Exceptions;

use Src\Exceptions\NonExistentClassException;

class NonExistentActionException extends NonExistentClassException
{
    public function __construct(
        string $message = "",
        private string $action,
    ) {
        parent::__construct($message, $action);
    }

    public function getAction(): string
    {
        return parent::getClass();
    }
}
