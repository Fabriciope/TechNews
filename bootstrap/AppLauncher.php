<?php

use Fabriciope\Router\Exceptions\{InvalidControllerMethodSignatureException, InvalidRequestInputDataException, InvalidRouteRequestException, RouteNotFoundException};
use Fabriciope\Router\Request\DefaultRequest;
use Fabriciope\Router\Routing\RouteManager;
use Fabriciope\Router\Routing\Router;

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
                throw new RouteNotFoundException($router->getRequest()->getPath());
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
