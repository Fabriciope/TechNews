<?php

use Src\Framework\Http\Exceptions\InvalidControllerMethodSignatureException;
use Src\Framework\Http\Exceptions\InvalidRequestInputDataException;
use Src\Framework\Http\Exceptions\InvalidRouteRequestException;
use Src\Framework\Http\Request\DefaultRequest;
use Src\Framework\Http\Routing\Route;
use Src\Framework\Http\Routing\RouteManager;
use Src\Framework\Http\Routing\Router;

final class AppLauncher
{
    public static function bootstrap(RouteManager $routeManager): void
    {
        self::loadEnvironmentVariables();

        self::initializeRouting($routeManager);
    }

    private static function initializeRouting(RouteManager $routeManager): void
    {
        try {
            $request = new DefaultRequest();
            $router = new Router($routeManager, $request);

            $route = $router->matchRequest();
            if (!$route) {
                renderErrorAndExit(
                    title: 'Error',
                    message: "Route not found for the path ({$router->getRequest()->path}) or invalid request method for this route",
                    code: 404
                );
            }

            $router->dispatchRoute($route);

        } catch (InvalidControllerMethodSignatureException $exception) {
            dump($exception);
        } catch (InvalidRequestInputDataException $exception) {
            echo($exception->getMessage());
        }
    }

    private static function loadEnvironmentVariables(): void
    {
        // TODO: abstrai o uso da biblioteca em uma classe
        $dir = __DIR__ . '/../';
        $dotenv = Dotenv\Dotenv::createImmutable($dir);
        $dotenv->load();
    }
}
