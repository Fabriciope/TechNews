<?php

namespace Src\Http\Controllers;

use Src\Core\Template\TemplatesEngine;
use Src\Support\FlashMessages\FlashMessage;
use Src\Support\FlashMessages\{FlashMessagesPublisher, FlashMessages};

abstract class Controller implements FlashMessagesPublisher
{
    use FlashMessages {
        FlashMessages::success as successMessage;
        FlashMessages::info as infoMessage;
        FlashMessages::warning as warningMessage;
        FlashMessages::error as errorMessage;
        FlashMessages::floatSuccess as floatSuccessMessage;
        FlashMessages::floatInfo as floatInfoMessage;
        FlashMessages::floatWarning as floatWarningMessage;
        FlashMessages::floatError as floatErrorMessage;
    }

    private TemplatesEngine $templatesEngine;

    public function __construct()
    {
        $this->flashMessage = new FlashMessage();
    }

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
