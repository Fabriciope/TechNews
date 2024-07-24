<?php

namespace Src\Http\Controllers\Web;

use Src\Core\Controller\WebController;
use Src\Http\Requests\Request;

class SiteController extends WebController
{
    public function __construct()
    {
        parent::__construct();
        parent::setUpTemplatesEngine(__DIR__ . '/../../../../resources/templates/views/site');
    }

    public function home(Request $request): void
    {
        dd($_SERVER, $_ENV);
        echo $this->renderTemplate('home', ['title' => env('APP_NAME')]);
    }
}
