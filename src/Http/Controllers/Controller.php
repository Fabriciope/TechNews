<?php

namespace Src\Http\Controllers;

use Src\Core\Template\TemplatesEngine;

abstract class Controller
{
    private TemplatesEngine $templatesEngine;

    /**
    * Controller constructor
    *
    * @throws \InvalidArgumentException
    */
    protected function setUpTemplatesEngine(string $viewsPath = __DIR__.'/../../../resources/templates/views/'): void
    {
        $this->templatesEngine = new TemplatesEngine($viewsPath);
        $this->getTemplatesEngine()->addFolder('layouts', __DIR__.'/../../../resources/templates/views/layouts/');
        $this->getTemplatesEngine()->addFolder('includes', __DIR__.'/../../../resources/templates/views/includes/');
    }

    protected function getTemplatesEngine(): TemplatesEngine
    {
        return $this->templatesEngine;
    }

    protected function renderTemplate(string $view, array $data = array()): string
    {
        $template = $this->getTemplatesEngine()->make($view);
        return $template->render($data);
    }
}
