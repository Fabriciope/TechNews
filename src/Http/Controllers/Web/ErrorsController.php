<?php

namespace Src\Http\Controllers\Web;

use Src\Framework\Core\Controller\WebController;
use Fabriciope\Router\Request\DefaultRequest as Request;

class ErrorsController extends WebController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
    * 400 - Bad Request
    *
    * @param Fabriciope\Router\Request\DefaultRequest $request
    */
    public function badRequest(Request $request): void
    {
        $this->renderError('Bad Request', 400);
    }

    /**
    * 404 - Not Found
    *
    * @param Fabriciope\Router\Request\DefaultRequest $request
    */
    public function notFound(Request $request): void
    {
        $this->renderError('Not Found', 404);
    }

    /**
    * 500 - Internal Server Error
    *
    * @param Fabriciope\Router\Request\DefaultRequest $request
    */
    public function internalServerError(Request $request): void
    {
        $this->renderError('Internal Server Error', 500);
    }

    private function renderError(string $title, $code): void
    {
        $session = session();

        if (!isset($session->redirectErrorMessage)) {
            \Fabriciope\Router\Response::redirect(route('/'));
        }

        $errorMessage = $session->redirectErrorMessage;
        $session->unset('redirectErrorMessage');

        renderErrorAndExit(
            title: $title,
            message: $errorMessage ?? '',
            code: $code
        );
    }
}
