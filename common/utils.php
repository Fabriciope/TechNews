<?php

// TODO: create asset function

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
