<?php

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
            return (string) $flashMessage;
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
            return (string) $flashMessage;
        }
    }

    return '';
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

function tojson(array $data): string
{
    return ''; // TODO: do this
}

function session(): Src\Core\Session
{
    return Src\Core\Session::getInstance();
}
