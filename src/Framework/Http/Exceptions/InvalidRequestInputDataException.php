<?php

namespace Src\Framework\Http\Exceptions;

class InvalidRequestInputDataException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
