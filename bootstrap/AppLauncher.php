<?php

use Src\Framework\Http\Exceptions\InvalidRequestInputDataException;
use Src\Framework\Core\Template\TemplatesEngine;
use Src\Framework\Http\Exceptions\InvalidRouteRequestException;
use Src\Framework\Http\Request\DefaultRequest;
use Src\Framework\Http\Routing\Router;

final class AppLauncher
{
    public static function bootstrap(Router $router): void
    {
        self::loadEnvironmentVariables();
        self::initializeRouter($router);
    }

    private static function initializeRouter(Router $router): void
    {
        try {
            $request = new DefaultRequest();
            $router->handleRequest($request);
        } catch (InvalidRouteRequestException $exception) {
            // TODO: log error ($this->getMessage())
            echo TemplatesEngine::renderErrorView(
                title: 'error',
                message:  $exception->getMessage(),
                code:  404
            );
            exit;
        } catch (InvalidRequestInputDataException $exception) {
            // TODO: redirecionar para a página anterior com a menssagem da exception
            dump($exception);
        }
    }

    private static function loadEnvironmentVariables(): void
    {
        // TODO: abstrai o uso da biblioteca em uma classe
        $dir = __DIR__.'/../';
        $dotenv = Dotenv\Dotenv::createImmutable($dir);
        $dotenv->load();
    }
}
