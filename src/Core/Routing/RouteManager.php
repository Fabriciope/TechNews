<?php

namespace Src\Core\Routing;

use Src\Http\HttpMethods;

class RouteManager extends RouteRecorder
{
    private array $routes;

    public function __construct()
    {
        foreach (HttpMethods::cases() as $method) {
            $this->routes[$method->name] = array();
        }
    }

    public function getRoutes(): array
    {
        return $this->routes;
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

    public function appendRoute(Route $route): void
    {
        array_push($this->routes[$route->method->name], $route);
    }


    public function newGroup(): RouteGroupManagerDecorator
    {
        return new RouteGroupManagerDecorator($this);
    }
}
