<?php

namespace Src\Exceptions;

class InvalidRequestInputDataException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
