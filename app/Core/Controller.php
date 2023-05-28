<?php

namespace App\Core;

use App\Core\ViewsEngine;
use App\Support\Message;

class Controller
{
    protected ViewsEngine $views;
    protected Message $message;

    public function __construct(string $pathViews = CONF_PATH_VIEWS, string $ext = 'php')
    {
        $this->views = new ViewsEngine($pathViews, $ext);
        $this->views->addFolder('layouts', __DIR__ . '/../../views/layouts')
                    ->addFolder('includes', __DIR__ . '/../../views/includes');
        
        $this->message = new Message;
    }
}