<?php

use Src\Core\Routing\Exceptions\InvalidRouteRequestException;
use Src\Core\Routing\Router;
use Src\Core\Template\TemplatesEngine;
use Src\Exceptions\InvalidRequestInputDataException;
use Src\Http\Requests\Request;

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
            $request = new Request();
            $router->handleRequest($request);
        } catch (InvalidRouteRequestException $exception) {
            // TODO: log error ($this->getMessage())
            echo TemplatesEngine::renderErrorView(
                title: 'error',
                message:  'iiiiiinvalid route',
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
        $dir = __DIR__.'/../';
        $dotenv = Dotenv\Dotenv::createImmutable($dir);
        $dotenv->load();
    }
}
