<?php

namespace Src\Framework\Http\Routing;

interface RouteRecorderInterface
{
    public function get(string $path, array|string $controllerAndAction): Route;

    public function post(string $path, array|string $controllerAndAction): Route;

    public function put(string $path, array|string $controllerAndAction): Route;

    public function patch(string $path, array|string $controllerAndAction): Route;

    public function delete(string $path, array|string $controllerAndAction): Route;
}
