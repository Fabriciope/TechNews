<?php

namespace Src\Framework\Http\Exceptions;

use Src\Framework\Http\Request\Request;

class InvalidControllerMethodSignatureException extends \BadMethodCallException
{
    private Request $request;

    private string $controllerClass;

    private string $method;

    public function __construct(Request $request, string $controller, string $method, string $message = '')
    {
        parent::__construct($message);

        $this->request = $request;
        $this->controllerClass = $controller;
        $this->method = $method;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
