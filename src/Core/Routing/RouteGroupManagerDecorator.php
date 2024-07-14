<?php

namespace Src\Core\Routing;

use InvalidArgumentException;
use Src\Http\HttpMethods;

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

    /**
    * sets the group prefix path
    *
    * @throws \InvalidArgumentException
    */
    public function setPrefix(string $prefix): RouteGroupManagerDecorator
    {
        if (empty($prefix)) {
            throw new \InvalidArgumentException('the prefix parameter must not be emtpy');
        }

        $this->prefix = $prefix;

        return $this;
    }

    public function setController(string $controllerClass): RouteGroupManagerDecorator
    {
        $this->controllerClass = $controllerClass;
        return $this;
    }

    /**
    * sets the group route middlewares
    *
    * @param string ...$middlewares
    * @throws \InvalidArgumentException
    */
    public function setMiddlewares(string ...$middlewares): RouteGroupManagerDecorator
    {
        foreach ($middlewares as $middleware) {
            array_push($this->middlewares, $middleware);
        }

        return $this;
    }

    /**
    * Resgister the routes given in the $groupFunc parameter function
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
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
