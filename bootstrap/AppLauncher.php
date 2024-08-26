<?php

use Src\Framework\Http\Exceptions\InvalidRequestInputDataException;
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
            // TODO: tratar melhor a request com a class router aqui, ou definir como propriedade da classe router
        } catch (InvalidRouteRequestException $exception) {
            // TODO: log error ($this->getMessage())
            renderErrorViewAndExit(
                title: 'Error',
                message: $exception->getMessage(),
                code:  404
            );
        } catch (InvalidRequestInputDataException $exception) {
            // TODO: redirecionar para a página anterior com a menssagem da exception
            //message: 'ocorreu um erro, mas fique tranquilo já estamos trabalhando nisso',
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
