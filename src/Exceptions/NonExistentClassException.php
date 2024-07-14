<?php

namespace Src\Exceptions;

class NonExistentClassException extends NonExistentException
{
    private string $className;

    public function __construct(string $message = '', string $class)
    {
        parent::__construct($message);
        $this->className = $class;
    }

    public function getClass(): string
    {
        return $this->className;
    }
}
