<?php

namespace Source\Core;

use Source\Core\ViewsEngine;

class Controller
{
    protected ViewsEngine $views;

    public function __construct(string $pathViews = CONF_PATH_VIEWS, string $ext = "php")
    {
        $this->views = new ViewsEngine($pathViews, $ext);
    }
}