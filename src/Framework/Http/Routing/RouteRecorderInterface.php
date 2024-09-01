<?php

namespace Src\Framework\Http\Routing;

interface RouteRecorderInterface
{
    /**
     * Resgister a new GET route
     *
     * @param string $path
     * @param array|string $controllerAndAction
     * @return Route
     * @throws \Src\Framework\Http\Exceptions\NonExistentControllerException
     * @throws \Src\Framework\Http\Exceptions\NonExistentActionException
     * @throws \Src\Framework\Http\Exceptions\NonExistentMiddlewareException
     * @throws \InvalidArgumentException
     */

    public function get(string $path, array|string $controllerAndAction): Route;

    /**
     * Resgister a new POST route
     *
     * @param string $path
     * @param array|string $controllerAndAction
     * @return Route
     * @throws \Src\Framework\Http\Exceptions\NonExistentControllerException
     * @throws \Src\Framework\Http\Exceptions\NonExistentActionException
     * @throws \Src\Framework\Http\Exceptions\NonExistentMiddlewareException
     * @throws \InvalidArgumentException
     */
    public function post(string $path, array|string $controllerAndAction): Route;

    /**
     * Resgister a new PUT route
     *
     * @param string $path
     * @param array|string $controllerAndAction
     * @return Route
     * @throws \Src\Framework\Http\Exceptions\NonExistentControllerException
     * @throws \Src\Framework\Http\Exceptions\NonExistentActionException
     * @throws \Src\Framework\Http\Exceptions\NonExistentMiddlewareException
     * @throws \InvalidArgumentException
     */
    public function put(string $path, array|string $controllerAndAction): Route;

    /**
     * Resgister a new PATCH route
     *
     * @param string $path
     * @param array|string $controllerAndAction
     * @return Route
     * @throws \Src\Framework\Http\Exceptions\NonExistentControllerException
     * @throws \Src\Framework\Http\Exceptions\NonExistentActionException
     * @throws \Src\Framework\Http\Exceptions\NonExistentMiddlewareException
     * @throws \InvalidArgumentException
     */
    public function patch(string $path, array|string $controllerAndAction): Route;

    /**
     * Resgister a new DELETE route
     *
     * @param string $path
     * @param array|string $controllerAndAction
     * @return Route
     * @throws \Src\Framework\Http\Exceptions\NonExistentControllerException
     * @throws \Src\Framework\Http\Exceptions\NonExistentActionException
     * @throws \Src\Framework\Http\Exceptions\NonExistentMiddlewareException
     * @throws \InvalidArgumentException
     */
    public function delete(string $path, array|string $controllerAndAction): Route;

    /**
     * Create a new group of routes
     *
     * @return \Src\Framework\Http\Routing\RouteGroupManagerDecorator
     */
    public function newGroup(): RouteGroupManagerDecorator;
}
