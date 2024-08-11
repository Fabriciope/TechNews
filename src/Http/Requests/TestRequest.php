<?php

namespace Src\Http\Requests;

use Src\Framework\Http\Exception\InvalidRequestBodyException;
use Src\Framework\Http\Request\DefaultRequest;
use Src\Framework\Interfaces\Validatable;

class TestRequest extends DefaultRequest implements Validatable
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validate(): void
    {
        //dump('inside validate');
        //throw new InvalidRequestBodyException('the message');
    }
}
