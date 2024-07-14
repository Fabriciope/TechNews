<?php

namespace Src\Core\Routing\Exceptions;

use Src\Http\Requests\Request;

class InvalidRouteRequestException extends \Exception
{
    private Request $request;

    public function __construct(string $message = '', Request $request)
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
