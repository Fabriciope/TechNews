<?php

namespace Src\Http\Controllers;

use Src\Http\Requests\Request;

class WebController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        parent::setUpTemplatesEngine(__DIR__ . '/../../../resources/templates/views/site');
    }

    public function home(Request $request): void
    {
        echo $this->renderTemplate('home', ['title' => env('APP_NAME')]);
    }
}
