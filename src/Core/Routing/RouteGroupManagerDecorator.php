<?php

namespace Src\Core\Routing;

use Src\Http\HttpMethods;
use Src\Http\Middleware\MiddlewareInterface;

class RouteGroupManagerDecorator extends RouteRecorder
{
    private string $prefix;

    private string $controllerClass;

    /**
    * Registered middlewares
    *
    * @var \Http\Middleware\MiddlewareInterface[] $middlewares
    */
    private array $middlewares = array();

    public function __construct(
        private RouteManager $routeManager
    ) {
    }

    public function setPrefix(string $prefix): RouteGroupManagerDecorator
    {
        // TODO: verificar parametro
        $this->prefix = $prefix;
        return $this;
    }

    public function setController(string $controllerClass): RouteGroupManagerDecorator
    {
        // TODO: verificar parametro
        $this->controllerClass = $controllerClass;
        return $this;
    }

    public function setMiddlewares(MiddlewareInterface ...$middlewares): RouteGroupManagerDecorator
    {
        // TODO: verificar parametro
        // TODO: do
        return $this;
    }

    public function group(callable $groupFunc): void
    {
        call_user_func($groupFunc, $this);
    }

    protected function addRoute(HttpMethods $method, string $path, array|string $controllerData): Route
    {
        $controller = null;
        $action = null;

        if (is_array($controllerData)) {
            list($controller, $action) = $controllerData;
        } elseif (is_string($controllerData)) {
            $controller = $this->controllerClass;
            $action = $controllerData;
        }

        if (!empty($this->prefix)) {
            $path = "/{$this->prefix}{$path}";
        }

        $route = new Route(
            method: $method,
            path: $path,
            controllerClass: $controller,
            actionName: $action
        );
        $route->setMiddlewares(...$this->middlewares);

        $this->routeManager->appendRoute($route);
        return $route;
    }
}
