<?php

namespace Src\Core\Controller;

abstract class Controller
{
    public function __construct()
    {
        static::setResponseHeaders();
    }

    abstract protected function setResponseHeaders();
}
