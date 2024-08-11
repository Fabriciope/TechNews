<?php

namespace Src\Framework\Http\Request;

use Src\Framework\Interfaces\Validatable;

class DefaultRequest extends Request implements Validatable
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validate(): void
    {

    }
}
