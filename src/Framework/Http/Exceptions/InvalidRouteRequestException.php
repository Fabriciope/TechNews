<?php

namespace Src\Framework\Http\Exceptions;

use Src\Framework\Http\Request\Request;

class InvalidRouteRequestException extends \Exception
{
    private Request $request;

    public function __construct(Request $request, string $message = '')
    {
        parent::__construct($message);
        $this->request = $request;
    }

    public function getMethodName(): string
    {
        return $this->request->getMethodName();
    }

    public function getPath(): string
    {
        return $this->request->path;
    }
}
