<?php

namespace Src\Exceptions;

class NonExistentClassException extends NonExistentException
{
    public function __construct(
        string $message = "",
        private string $class,
    ) {
        parent::__construct($message);
    }

    public function getClass(): string
    {
        return $this->class;
    }
}
