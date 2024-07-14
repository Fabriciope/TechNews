<?php

namespace Src\Core\Routing\Exceptions;

use Src\Exceptions\NonExistentException;

class NonExistentActionException extends NonExistentException
{
    private string $actionName;

    public function __construct(string $message = '', string $actionName)
    {
        parent::__construct($message);
        $this->actionName = $actionName;
    }

    public function getAction(): string
    {
        return $this->actionName;
    }
}
