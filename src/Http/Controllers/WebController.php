<?php

namespace Src\Http\Controllers;

use Src\Http\Requests\Request;

class WebController
{
    public function home(Request $request): void
    {
        echo "<pre>";
        var_dump($request);
        echo "</pre>";
    }

    public function user(Request $request): void
    {
        echo "<pre>";
        var_dump($request->getFromPath('other'), $request->getFromPath('id'));
        echo "</pre>";
    }
}
