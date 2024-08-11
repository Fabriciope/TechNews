<?php

namespace Src\Core\Routing\Exceptions;

class InvalidMethodRequestParameterException extends \BadMethodCallException
{
    private string $parameterClass;

    public function __construct(string $parameterClass, string $message = '')
    {
        parent::__construct($message);
        $this->parameterClass = $parameterClass;
    }

    public function getParameterClass(): string
    {
        return $this->parameterClass;
    }
}
