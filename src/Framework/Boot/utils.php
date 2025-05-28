<?php

use Fabriciope\Router\Response;

/**
 * ###########################
 * ###   VIEWS FUNCTIONS   ###
 * ###########################
 */

function script(string $fileName): string
{
    return env('APP_URL') . "/assets/scripts/{$fileName}.js";
}

function css(string $fileName): string
{
    return env('APP_URL') . "/assets/styles/{$fileName}.css";
}

function image(string $image): string
{
    return env('APP_URL') . "/assets/images/{$image}";
}

function float_flash_message(): string
{
    if (isset(session()->flash_message)) {
        $flashMessage = session()->get('flash_message');
        if ($flashMessage->isFloat()) {
            session()->unset('flash_message');
            return (string)$flashMessage;
        }
    }

    return '';
}

function flash_message(): string
{
    if (isset(session()->flash_message)) {
        $flashMessage = session()->get('flash_message');
        if (!$flashMessage->isFloat()) {
            session()->unset('flash_message');
            return (string)$flashMessage;
        }
    }

    return '';
}

function method(string $method): string
{
    if (!Fabriciope\Router\HttpMethods::caseExists($method)) {
        return '';
    }

    return <<<INPUT
        <input hidden name="_method" value="{$method}">
    INPUT;
}

function route(string $path): string
{
    return env('APP_URL') . (str_starts_with($path, '/') ? $path : "/{$path}");
}

function redirectToErrorPage(string $message, int $code): void
{
    session()->set('redirectErrorMessage', $message);
    $url = '/error/' . strval($code);
    Response::redirect(route($url), $code);
}


/**
 * Get an invironment variable from .env file
 *
 * @param string $key
 * @param string $default
 * @return string|int|bool
 */
function env(string $key, string $default = ''): string|int|bool
{
    return @$_ENV[$key] ? $_ENV[$key] : $default;
}

function toJson(array $data, int $flags = JSON_PRETTY_PRINT): string
{
    return json_encode($data, $flags);
}

function session(): Src\Framework\Core\Session
{
    return Src\Framework\Core\Session::getInstance();
}


/**
 * #########################
 * ###   RETURN ERRORS   ###
 * #########################
 */

function renderErrorTemplateAndExit(int $code, string $title = '', string $message = ''): void
{
    \Fabriciope\Router\Response::setStatusCode($code);
    echo \Src\Framework\Core\TemplatesEngine::renderErrorView(
        title: $title,
        message: $message,
        code: $code
    );
    exit(1);
}

function renderAPIErrorAndExit(string $message = '', int $code = 500): void
{
    echo toJson([
        'error' => true,
        'message' => $message,
        'response_code' => $code,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit(1);
}

function endRequestWithError(string $message, int $code): void
{
    if (Fabriciope\Router\Request\Request::isAPIRequest()) {
        Fabriciope\Router\Response::setAPIHeaders();
        renderAPIErrorAndExit($message, $code);
        return;
    }

    redirectToErrorPage($message, $code);
}
