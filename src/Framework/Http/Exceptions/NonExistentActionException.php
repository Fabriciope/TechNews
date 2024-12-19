<?php

namespace Src\Framework\Http\Exceptions;

use Src\Framework\Exceptions\NonExistentException;

class NonExistentActionException extends NonExistentException
{
    private string $actionName;

    public function __construct(string $actionName, string $message = '')
    {
        parent::__construct($message);
        $this->actionName = $actionName;
    }

    public function getAction(): string
    {
        return $this->actionName;
    }
}
