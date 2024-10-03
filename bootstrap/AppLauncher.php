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
        // TODO: criar um repositorio separado para publicar o modulo de routing no packagist
        try {
            $request = new DefaultRequest();
            $router = new Router($routeManager, $request);

            $route = $router->matchRequest();
            if (!$route) {
                renderErrorAndExit(
                    title: "Error",
                    message: "Route not found for the path ({$router->getRequest()->path}) or invalid request method for this route",
                    code: 404
                );
            }

            $router->dispatchRoute($route);
        } catch (InvalidRequestInputDataException $exception) {
            // TODO: redirect back and save error at session
            dd($exception->getMessage());
        } catch (InvalidControllerMethodSignatureException | \InvalidArgumentException $exception) {
            // TODO: pensar em redirecionar para a pagina de erro e criar um controller somente para tratar disso;
            renderErrorAndExit(
                title: "Erro interno",
                message: "Oops!, algo deu errado. Já estamos trabalhando nisso"
            );
        }// TODO: add InvalitRouteRequestException catch
    }

    private static function loadEnvironmentVariables(): void
    {
        (new \Src\Framework\Core\DotEnv(__DIR__ . "/../"))->loadEnvironment();
    }
}
