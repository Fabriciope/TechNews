<?php

namespace App\Core;

use League\Plates\Engine;

class ViewsEngine
{
    private Engine $platesEngine;

    public function __construct(string $pathViews, string $ext = 'php')
    {
        $this->platesEngine = new Engine($pathViews, $ext);
    }

    public function addFolder(string $name, string $path): ViewsEngine
    {
        $this->platesEngine->addFolder($name, $path);
        return $this;
    }

    public function render(string $templateName, array $data): string
    {
        $this->platesEngine->addData($data);
        return $this->platesEngine->render($templateName);
    }

    public function engine(): Engine
    {
        return $this->platesEngine;
    }
}