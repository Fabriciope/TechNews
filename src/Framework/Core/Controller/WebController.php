<?php

namespace Src\Framework\Core\Controller;

use Src\Framework\Core\TemplatesEngine;
use Src\Framework\Http\Response;
use Src\Framework\Support\Messages\FlashMessages;

abstract class WebController extends Controller
{
    use FlashMessages;

    private TemplatesEngine $templatesEngine;

    public function __construct()
    {
        parent::__construct();
    }

    protected function setResponseHeaders()
    {
        Response::setContentType('text/html');
    }

    /**
    * Controller constructor
    *
    * @throws \InvalidArgumentException
    */
    protected function setUpTemplatesEngine(string $viewsPath = __DIR__.'/../../../../resources/templates/views/'): void
    {
        try {
            $this->templatesEngine = new TemplatesEngine($viewsPath);
            $this->getTemplatesEngine()->addFolder('layouts', __DIR__.'/../../../../resources/templates/views/layouts/');
            $this->getTemplatesEngine()->addFolder('includes', __DIR__.'/../../../../resources/templates/views/includes/');
        } catch (\InvalidArgumentException $exception) {
            // TODO: return internal error and log it
            dd($exception);
        }
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
