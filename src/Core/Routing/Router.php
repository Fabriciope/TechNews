<?php

namespace Src\Core\Routing;

use Src\Core\Interfaces\Validatable;
use Src\Core\Middleware\MiddlewaresHandler;
use Src\Core\Routing\Exceptions\InvalidMethodRequestParameterException;
use Src\Core\Routing\Exceptions\InvalidRouteRequestException;
use Src\Core\Request\Request;

class Router
{
    private RouteManager $routeManager;

    // TODO: pass request thorugh construct parameter
    public function __construct()
    {
        $this->routeManager = new RouteManager();
    }

    public function getRouteManager(): RouteManager
    {
        return $this->routeManager;
    }

    private function getRoutes(): array
    {
        return $this->routeManager->getRoutes();
    }

    /**
    * Match route from request
    *
    * @throws Src\Core\Routing\Exceptions\InvalidRouteRequestException
    * @throws Src\Exceptions\InvalidRequestInputDataException
    * @throws Src\Exceptions\InvalidRequestBodyException
    */
    public function handleRequest(Request $request)
    {
        $this->dispatch($request);
    }

    private function dispatch(Request $request): void
    {
        $methodName = $request->getMethodName();
        $routes = $this->getRoutes()[$methodName];

        foreach ($routes as $route) {
            if (!self::matchRequestPath($route->path, $request->path)) {
                continue;
            }

            $this->runRoute($route, $request);
            return;
        }

        throw new InvalidRouteRequestException(
            $request,
            "Route not found for the path \"{$request->path}\" and {$request->getMethodName()} method"
        );
    }

    private static function matchRequestPath(string $routePath, string $requestPath): bool
    {
        $splittedRequestPath = explode("/", trim($requestPath, '/'));
        $splittedRoutePath = explode("/", trim($routePath, '/'));

        if (count($splittedRequestPath) != count($splittedRoutePath)) {
            return false;
        }

        foreach ($splittedRoutePath as $subPathIndex => $subPath) {
            if ((substr($subPath, 0, 1) == "{") and (substr($subPath, -1) == "}")) {
                continue; // NOTE: indicates that the route has a parameter
            }

            if ($subPath != $splittedRequestPath[$subPathIndex]) {
                return false;
            }
        }

        return true;
    }

    private function runRoute(Route $route, Request $request): void
    {
        $request->bindPathParameters($route->path);
        $this->performMiddlewares($route, $request);

        try {
            $newRequest = $this->getRequestValidatableFromActionParameter($route);
            if (!is_null($newRequest)) {
                $request = $newRequest;
                $this->performRequestValidator($request);
            }
        } catch (InvalidMethodRequestParameterException $exception) {
            // TODO: loggar o erro
            $wrongObjectClass = $exception->getParameterClass();
            $request =  new $wrongObjectClass();
        }

        $this->performControllerAction($route, $request);
        return;
    }

    private function getRequestValidatableFromActionParameter(Route $route): ?Request
    {
        $controller = new $route->controllerClass();
        $rMethod = new \ReflectionMethod($controller, $route->actionName);
        $rParameters = $rMethod->getParameters();

        if (count($rParameters) == 0) {
            return null;
        }

        $requestClass = $rParameters[0]->getType()->getName();
        if (!in_array(Validatable::class, class_implements($requestClass))) {
            if ($requestClass != Request::class) {
                throw new InvalidMethodRequestParameterException(
                    $requestClass,
                    'if the first parameter of the controller action is diferent from Request class, it must implements the Validatable interface'
                );
            }
            return null;
        }

        $newRequest = new $requestClass();
        $newRequest->bindPathParameters($route->path);
        return $newRequest;
    }


    private function performMiddlewares(Route $route, Request $request): void
    {
        $middlewareManager = new MiddlewaresHandler($route->middlewares);
        $middlewareManager->handle($request);
    }

    private function performRequestValidator(\Src\Core\Interfaces\Validatable $request): void
    {
        $request->validate();
    }

    private function performControllerAction(Route $route, Request $request): void
    {
        $controller = new $route->controllerClass();
        $controller->{$route->actionName}($request);
    }
}
