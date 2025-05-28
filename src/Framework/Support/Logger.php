<?php

namespace Src\Framework\Support;

class Logger
{
    public static function critical(string $message): void
    {
        static::log(sprintf('**CRITICAL**: %s%s', $message, PHP_EOL));
    }

    public static function error(string $message): void
    {
        static::log(sprintf('**ERROR**: %s%s', $message, PHP_EOL));
    }

    public static function warning(string $message): void
    {
        static::log(sprintf('**WARNING**: %s%s', $message, PHP_EOL));
    }

    public static function debug(string $message): void
    {
        static::log(sprintf('**DEBUG**: %s%s', $message, PHP_EOL));
    }

    protected static function log(string $message): void
    {
        # TODO: usar trigger_error em producao e set_error_handler
        # TODO: adicionar timestamp
        error_log($message, 3, env('APP_LOG_FILE', '/var/www/technews/logs/php-fpm/www.app.log'));
    }
}
