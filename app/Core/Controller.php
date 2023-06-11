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

    protected static function getModel(string $model): \App\Core\Model
    {
        if(str_contains($model, 'User')) {
            $class = "\\App\\Models\\" . ucfirst($model);
            return new $class;
        } else {
            $class = "\\App\\Models\\Article\\" . ucfirst($model);
            return new $class;
        }
    }
}