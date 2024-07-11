<?php

namespace Src\Core\Routing;

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

    public function handleRequest(Request $request): void
    {
        $this->match($request);
    }

    /**
    * Match route from request
    *
    * @throws \Src\Core\Routing\Exceptions\InvalidRouteRequestException
    */
    private function match(Request $request)
    {
        $routes = $this->getRoutes()[$request->getMethodName()];
        $requestPath = $request->path;

        foreach($routes as $route) {
            if (!$this->matchRequestPath($route->path, $requestPath)) {
                continue;
            }

            $request->bindPathParameters($route->path);
            $this->performControllerAction($route, $request);
            return;
        }

        throw new InvalidRouteRequestException(
            "Route not found for the path \"{$request->path}\" and {$request->getMethodName()} method",
            $request
        );
    }

    private function matchRequestPath(string $routePath, string $requestPath): bool
    {
        $splittedRequestPath = explode("/", trim($requestPath, '/'));
        $splittedRoutePath = explode("/", trim($routePath, '/'));

        if (count($splittedRequestPath) != count($splittedRoutePath)) {
            return false;
        }

        foreach($splittedRoutePath as $subPathIndex => $subPath) {
            if ((substr($subPath, 0, 1) == "{") and (substr($subPath, -1) == "}")) {
                continue; // NOTE: indicates that the route has a parameter
            }

            if ($subPath != $splittedRequestPath[$subPathIndex]) {
                return false;
            }
        }

        return true;
    }

    public function performControllerAction(Route $route, Request $request): void
    {
        $controller = new $route->controllerClass();
        $controller->{$route->actionName}($request);
    }
}
