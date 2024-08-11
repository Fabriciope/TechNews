<?php

namespace Src\Http\Requests;

use Src\Core\Interfaces\Validatable;
use Src\Core\Request\Request;
use Src\Exceptions\InvalidRequestBodyException;

class TestRequest extends Request implements Validatable
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
