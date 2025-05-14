<?php

namespace Src\Framework\Core\Controller;

use Fabriciope\Router\Response;
use Src\Framework\Support\Messages\FlashMessages;

abstract class APIController extends Controller
{
    use FlashMessages;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setResponseHeaders(): void
    {
        Response::setAPIHeaders();
    }
}
