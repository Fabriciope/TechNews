<?php

namespace Src\Core\Routing;

use Src\Core\Middleware\MiddlewareManager;
use Src\Core\Routing\Exceptions\InvalidRouteRequestException;
use Src\Http\Requests\Request;

class Router
{
    private RouteManager $routeManager;

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
    */
    public function handleRequest(Request $request)
    {
        $routes = $this->getRoutes()[$request->getMethodName()];
        $requestPath = $request->path;

        foreach ($routes as $route) {
            if (!self::matchRequestPath($route->path, $requestPath)) {
                continue;
            }

            $request->bindPathParameters($route->path);
            $this->performMiddlewares($route, $request);
            $this->performControllerAction($route, $request);
            return;
        }

        throw new InvalidRouteRequestException(
            "Route not found for the path \"{$request->path}\" and {$request->getMethodName()} method",
            $request
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

    private function performMiddlewares(Route $route, Request $request): void
    {
        $middlewareManager = new MiddlewareManager($route->middlewares);
        $middlewareManager->handle($request);
    }

    private function performControllerAction(Route $route, Request $request): void
    {
        $controller = new $route->controllerClass();
        $controller->{$route->actionName}($request);
    }
}
