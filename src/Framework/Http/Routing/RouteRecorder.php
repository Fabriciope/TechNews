<?php

namespace Src\Framework\Http\Routing;

use Src\Framework\Http\HttpMethods;

abstract class RouteRecorder
{
    abstract protected function addRoute(HttpMethods $method, string $path, array|string $controllerData): Route;

    /**
    * Resgister a new GET route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function get(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::GET, $path, $controllerAndAction);
    }

    /**
    * Resgister a new POST route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function post(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::POST, $path, $controllerAndAction);
    }

    /**
    * Resgister a new PUT route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function put(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::PUT, $path, $controllerAndAction);
    }

    /**
    * Resgister a new PATCH route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function patch(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::PATCH, $path, $controllerAndAction);
    }

    /**
    * Resgister a new DELETE route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function delete(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::DELETE, $path, $controllerAndAction);
    }

    public function newGroup(): RouteGroupManagerDecorator
    {
        return new RouteGroupManagerDecorator($this);
    }
}
