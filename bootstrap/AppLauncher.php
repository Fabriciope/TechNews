<?php

use Src\Framework\Http\Exceptions\{InvalidControllerMethodSignatureException, InvalidRequestInputDataException, InvalidRouteRequestException, RouteNotFoundException};
use Src\Framework\Http\Request\DefaultRequest;
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
                throw new RouteNotFoundException($router->getRequest()->path);
            }

            $router->dispatchRoute($route);
        } catch (InvalidRequestInputDataException $exception) {
            session()->set('redirectErrorMessage', $exception->getMessage());
            redirectToErrorPage(500);
        } catch (InvalidControllerMethodSignatureException | \InvalidArgumentException $exception) {
            session()->set('redirectErrorMessage', 'Oops!, algo deu errado. Já estamos trabalhando nisso');
            redirectToErrorPage(500);
        } catch (RouteNotFoundException $exception) {
            session()->set('redirectErrorMessage', $exception->getMessage());
            redirectToErrorPage(404);
        } catch (InvalidRouteRequestException $exception) {
            session()->set('redirectErrorMessage', $exception->getMessage());
            redirectToErrorPage(400);
        }
    }

    private static function loadEnvironmentVariables(): void {
        (new \Src\Framework\Core\DotEnv(__DIR__ . "/../"))->loadEnvironment();
    }
}
