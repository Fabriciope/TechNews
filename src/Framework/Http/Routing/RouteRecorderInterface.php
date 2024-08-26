<?php

namespace Src\Framework\Http\Routing;

interface RouteRecorderInterface
{
    /**
    * Resgister a new GET route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function get(string $path, array|string $controllerAndAction): Route;

    /**
    * Resgister a new POST route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function post(string $path, array|string $controllerAndAction): Route;

    /**
    * Resgister a new PUT route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function put(string $path, array|string $controllerAndAction): Route;

    /**
    * Resgister a new PATCH route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function patch(string $path, array|string $controllerAndAction): Route;

    /**
    * Resgister a new DELETE route
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function delete(string $path, array|string $controllerAndAction): Route;

    /**
    * Create a new group of routes
    *
    * @param Src\Core\Routing\Route $route
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function newGroup(): RouteGroupManagerDecorator;
}
