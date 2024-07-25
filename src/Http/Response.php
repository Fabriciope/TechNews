<?php

namespace Src\Http;

use Src\Http\Requests\Request;

class Response
{
    public static function setHeader(string $key, string $value): void
    {
        if (empty($key) or empty($value)) {
            throw new \InvalidArgumentException('the parameters must not be emtpy');
        }

        header("{$key}: {$value}");
    }

    public static function setStatusLine(string $line): void
    {
        header($line, true);
    }

    public static function setContentType(string $type, string $charset = 'UTF-8'): void
    {
        self::setHeader('Content-Type', "{$type}; {$charset}");
    }

    public static function setStatusCode(int $code, string $message = ''): void
    {
        if (function_exists('http_response_code')) {
            http_response_code($code);
            return;
        }

        self::setStatusLine(
            sprintf(
                "%s %d %s",
                Request::getServerVar('HTTP_PROTOCOL'),
                $code,
                $message
            )
        );
    }
}
