<?php

namespace Src\Http\Controllers;

use Src\Http\Requests\Request;

class WebController extends Controller
{
    public function __construct()
    {
        parent::setUpTemplatesEngine(__DIR__ . '/../../../resources/templates/views/site');
    }

    public function home(): void
    {
        echo $this->renderTemplate('home', ['title' => 'home page']);
    }

    public function user(Request $request): void
    {
        echo "<pre>";
        var_dump($request->getFromPath('other'), $request->getFromPath('id'));
        echo "</pre>";
    }
}
