<?php

namespace Src\Framework\Http\Exceptions;

class InvalidRequestBodyException extends  \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
