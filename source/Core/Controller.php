<?php

namespace Source\Core;

use Source\Core\ViewsEngine;

class Controller
{
    protected ViewsEngine $views;

    public function __construct(string $pathViews = CONF_PATH_VIEWS, string $ext = 'php')
    {
        $this->views = new ViewsEngine($pathViews, $ext);
        $this->views->addFolder('layouts', __DIR__ . '/../../views/layouts')
                    ->addFolder('includes', __DIR__ . '/../../views/includes');
    }
}