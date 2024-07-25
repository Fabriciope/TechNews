<?php

namespace Src\Core\Controller;

use Src\Http\Response;
use Src\Support\Messages\FlashMessages;

abstract class APIController extends Controller
{
    use FlashMessages;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setResponseHeaders()
    {
        Response::setContentType('application/json');
    }
}
