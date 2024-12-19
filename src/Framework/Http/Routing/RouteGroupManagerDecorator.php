<?php

namespace Src\Framework\Http\Routing;

use InvalidArgumentException;
use Src\Framework\Http\HttpMethods;

class RouteGroupManagerDecorator extends RouteRecorder
{
    private string $prefix = '';

    private string $controllerClass;

    /**
    * Registered middlewares
    *
    * @var \Http\Middleware\MiddlewareInterface[] $middlewares
    */
    private array $middlewares = array();

    public function __construct(
        private RouteRecorder $routeManager
    ) {
    }

    /**
    * Sets the group prefix path
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
        if (empty($controllerClass)) {
            throw new \InvalidArgumentException('the controllerClass parameter must not be emtpy');
        }

        $this->controllerClass = $controllerClass;
        return $this;
    }

    /**
    * Sets the group route middlewares
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
        $controller = $this->getActualController($controllerData);
        $action = $this->getActualAction($controllerData);
        $path = $this->getFullPath($path);

        $registeredRoute = $this->routeManager->addRoute($method, $path, [$controller, $action]);
        $registeredRoute->setMiddlewares(...$this->middlewares);

        return $registeredRoute;
    }

    private function getActualController(array|string $controllerData): string
    {
        if (is_string($controllerData)) {
            if (!empty($this->controllerClass)) {
                return $this->controllerClass;
            }

            if ($this->routeManager instanceof RouteGroupManagerDecorator) {
                $controller = $this->routeManager->controllerClass;

                return $controller;
            }
        }

        if (is_array($controllerData)) {
            return $controllerData[0];
        }

        throw new \InvalidArgumentException('Set the controller class first');
    }

    private function getActualAction(array|string $controllerData): string
    {
        if (is_string($controllerData)) {
            return $controllerData;
        }

        if (is_array($controllerData)) {
            return $controllerData[1];
        }

        return '';
    }

    private function getFullPath(string $path): string
    {
        if (!empty($this->prefix)) {
            $path = "/{$this->prefix}{$path}";
        }

        return substr($path, 0, 2) === '//' ? substr($path, 1) : $path;
    }
}
