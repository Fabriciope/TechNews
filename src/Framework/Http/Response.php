<?php

namespace Src\Framework\Http;

use Src\Framework\Http\Request\Request;

class Response
{
    public static function setHeader(string $key, string $value, int $statusCode = 0): void
    {
        if (empty($key) or empty($value)) {
            throw new \InvalidArgumentException('the parameters must not be emtpy');
        }

        header("{$key}: {$value}", $statusCode);
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

    public static function redirect(string $url, int $statusCode = 308): void
    {
        $urlParsed = parse_url($url);
        if (isset($urlParsed['scheme']) || isset($urlParsed['host'])) {
            $opts = ['flags' => FILTER_SANITIZE_URL | FILTER_FLAG_PATH_REQUIRED];
            $url = filter_var($url, FILTER_VALIDATE_URL, $opts);
            if (!$url) {
                throw new \InvalidArgumentException('the given url is invalid');
            }

            self::setStatusCode($statusCode);
            self::setHeader('Location', $url, $statusCode);
            exit;
        }

        $url = filter_var($url, options: FILTER_FLAG_PATH_REQUIRED);
        if (!$url) {
            throw new \InvalidArgumentException('the given path is invalid');
        }

        $url = env('APP_URL') . $url;
        self::setStatusCode($statusCode);
        self::setHeader('Location', $url, $statusCode);
        exit;
    }

    public static function setAPIHeaders(): void
    {
        Response::setContentType('application/json');
    }
}
