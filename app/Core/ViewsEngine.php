<?php

namespace App\Core;

use League\Plates\Engine;

/**
 * Classe de renderização das views
 */
class ViewsEngine
{
    private Engine $platesEngine;
    
    /**
     * __construct
     *
     * @param  string $pathViews
     * @param  string $ext
     * @return void
     */
    public function __construct(string $pathViews, string $ext = 'php')
    {
        $this->platesEngine = new Engine($pathViews, $ext);
    }
    
    /**
     * addFolder
     *
     * @param  string $name
     * @param  string $path
     * @return ViewsEngine
     */
    public function addFolder(string $name, string $path): ViewsEngine
    {
        $this->platesEngine->addFolder($name, $path);
        return $this;
    }
    
    /**
     * render
     *
     * @param  string $templateName
     * @param  array $data
     * @return string
     */
    public function render(string $templateName, array $data): string
    {
        $this->platesEngine->addData($data);
        return $this->platesEngine->render($templateName);
    }
    
    /**
     * engine
     *
     * @return Engine
     */
    public function engine(): Engine
    {
        return $this->platesEngine;
    }
}