<?php

namespace Src\Core\Routing\Exceptions;

use Src\Http\HttpMethods;
use Src\Http\Requests\Request;
use Src\Core\Routing\Route;

class InvalidRouteRequestException extends \Exception
{
    public function __construct(
        string $message = "",
        private Request $request,
    ) {
        parent::__construct($message);
    }

    public function getMethod(): HttpMethods
    {
        return $this->request->getMethod();
    }

    public function getPath(): string
    {
        return $this->request->path;
    }
}
