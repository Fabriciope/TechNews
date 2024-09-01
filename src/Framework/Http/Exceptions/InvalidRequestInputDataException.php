<?php

namespace Src\Framework\Http\Exceptions;

class InvalidRequestInputDataException extends InvalidRequestBodyException
{
    private string $inputName;

    public function __construct(string $input, string $message)
    {
        parent::__construct($message);

        $this->inputName = $input;
    }

    public function getInputName(): string
    {
        return $this->inputName;
    }
}
