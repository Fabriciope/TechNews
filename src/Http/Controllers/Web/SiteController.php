<?php

namespace Src\Http\Controllers\Web;

use Src\Framework\Core\Controller\WebController;
use Src\Framework\Http\Request\Request;
use Src\Framework\Http\Response;
use Src\Http\Requests\TestRequest;

class SiteController extends WebController
{
    /**
     * SiteController constructor
     *
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct();
        parent::setUpTemplatesEngine(__DIR__ . '/../../../../resources/templates/views/site');
    }

    public function home(Request $request): void
    {
        echo $this->renderTemplate('home', ['title' => env('APP_NAME')]);
    }
}
