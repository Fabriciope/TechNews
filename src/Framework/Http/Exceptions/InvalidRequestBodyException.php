<?php

namespace Src\Framework\Http\Exceptions;

class InvalidRequestBodyException extends InvalidRequestInputDataException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}