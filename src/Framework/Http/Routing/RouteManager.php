<?php

namespace Src\Framework\Http\Routing;

use Src\Framework\Http\HttpMethods;

class RouteManager extends RouteRecorder
{
    private array $routesMap;// TODO: estudar pq isso esta na variavel @GLOBALS

    private string $prefix;

    private string $controllerClass;

    /**
    * Registered middlewares
    *
    * @var \Http\Middleware\MiddlewareInterface[] $middlewares
    */
    private array $middlewares = array();

    public function __construct()
    {
        foreach (HttpMethods::cases() as $method) {
            $this->routesMap[$method->name] = array();
        }
    }

    public function getRoutes(): array
    {
        return $this->routesMap;
    }

    protected function addRoute(HttpMethods $method, string $path, array|string $controllerData): Route
    {
        if(is_string($controllerData) or (count($controllerData) != 2)) {
            throw new \InvalidArgumentException("Controller and action must be passed within an array");
        }

        list($controller, $action) = $controllerData;

        $route = new Route(
            method: $method,
            path: $path,
            controllerClass: $controller,
            actionName: $action
        );

        $this->appendRoute($route);
        return $route;
    }

    private function appendRoute(Route $route): void
    {
        array_push($this->routesMap[$route->method->name], $route);
    }
}
