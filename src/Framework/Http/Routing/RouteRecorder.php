<?php

namespace Src\Framework\Http\Routing;

use Src\Framework\Http\HttpMethods;

abstract class RouteRecorder implements RouteRecorderInterface
{
    abstract protected function addRoute(HttpMethods $method, string $path, array|string $controllerData): Route;

    public function get(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::GET, $path, $controllerAndAction);
    }

    public function post(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::POST, $path, $controllerAndAction);
    }

    public function put(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::PUT, $path, $controllerAndAction);
    }

    public function patch(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::PATCH, $path, $controllerAndAction);
    }

    public function delete(string $path, array|string $controllerAndAction): Route
    {
        return $this->addRoute(HttpMethods::DELETE, $path, $controllerAndAction);
    }

    public function newGroup(): RouteGroupManagerDecorator
    {
        return new RouteGroupManagerDecorator($this);
    }
}
