<?php

namespace Src\Framework\Support;

class Logger
{
    public static function fatal(string $message): void
    {
        static::log(sprintf('FATAL: %s%s', $message, PHP_EOL));
    }

    public static function error(string $message): void
    {
        static::log(sprintf('ERROR: %s%s', $message, PHP_EOL));
    }

    public static function warning(string $message): void
    {
        static::log(sprintf('WARNING: %s%s', $message, PHP_EOL));
    }

    public static function debug(string $message): void
    {
        static::log(sprintf('DEBUG: %s%s', $message, PHP_EOL));
    }

    protected static function log(string $message): void
    {
        error_log($message, 3, env('APP_LOG_FILE', '/app/storage/logs/app.log'));
    }
}
