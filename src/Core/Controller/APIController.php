<?php

namespace Src\Core\Controller;

use Src\Http\Response;

abstract class APIController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function setResponseHeaders()
    {
        Response::setContentType('application/json');
    }
}
