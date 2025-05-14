<?php

namespace Src\Framework\Core\Controller;

use Src\Framework\Core\TemplatesEngine;
use Fabriciope\Router\Response;
use Src\Framework\Support\Messages\FlashMessages;

abstract class WebController extends Controller
{
    use FlashMessages;

    private TemplatesEngine $templatesEngine;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setResponseHeaders(): void
    {
        Response::setContentType('text/html');
    }

    protected function setUpTemplatesEngine(string $viewsPath = __DIR__ . '/../../../../resources/templates/views/'): void
    {
        $this->templatesEngine = new TemplatesEngine($viewsPath);
        $this->getTemplatesEngine()->addFolder('layouts', __DIR__ . '/../../../../resources/templates/views/layouts/');
        $this->getTemplatesEngine()->addFolder('includes', __DIR__ . '/../../../../resources/templates/views/includes/');
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
