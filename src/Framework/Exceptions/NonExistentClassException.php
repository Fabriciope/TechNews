<?php

namespace Src\Framework\Exceptions;

class NonExistentClassException extends NonExistentException
{
    private string $className;

    public function __construct(string $class, string $message = '')
    {
        parent::__construct($message);
        $this->className = $class;
    }

    public function getClass(): string
    {
        return $this->className;
    }
}
