<?php

namespace Tests\Feature\Routing;

use PHPUnit\Framework\TestCase;
use Src\Framework\Http\Exceptions\NonExistentActionException;
use Src\Framework\Http\Exceptions\NonExistentControllerException;
use Src\Framework\Http\Exceptions\NonExistentMiddlewareException;
use Src\Framework\Http\HttpMethods;
use Src\Framework\Http\Routing\Route;
use Src\Framework\Http\Routing\RouteManager;
use Src\Http\Controllers\Web\SiteController;
use Src\Http\Middlewares\Guest;

class RouteCreationTest extends TestCase
{
    private RouteManager $routeManager;

    protected function setUp(): void
    {
        $this->routeManager = new RouteManager();
    }

    public function test_if_can_be_created(): void
    {
        $route = $this->routeManager;
        $route->get('/', [SiteController::class, 'home']);
        $route->post('/create', [SiteController::class, 'home']);
        $route->put('/update', [SiteController::class, 'home']);
        $route->patch('/update-name', [SiteController::class, 'home']);
        $route->delete('/remove', [SiteController::class, 'home']);

        $routes = $this->routeManager->getRoutes();
        $this->assertIsArray($routes);

        self::assertRoute(
            new Route(
                path: '/',
                method: HttpMethods::GET,
                controllerClass: SiteController::class,
                actionName: 'home'
            ),
            $routes['GET'][0]
        );

        self::assertRoute(
            new Route(
                path: '/create',
                method: HttpMethods::POST,
                controllerClass: SiteController::class,
                actionName: 'home'
            ),
            $routes['POST'][0]
        );

        self::assertRoute(
            new Route(
                path: '/update',
                method: HttpMethods::PUT,
                controllerClass: SiteController::class,
                actionName: 'home'
            ),
            $routes['PUT'][0]
        );

        self::assertRoute(
            new Route(
                path: '/update-name',
                method: HttpMethods::PATCH,
                controllerClass: SiteController::class,
                actionName: 'home'
            ),
            $routes['PATCH'][0]
        );

        self::assertRoute(
            new Route(
                path: '/remove',
                method: HttpMethods::DELETE,
                controllerClass: SiteController::class,
                actionName: 'home'
            ),
            $routes['DELETE'][0]
        );
    }

    public function test_should_throw_an_exception_when_passing_an_invalid_controller(): void
    {
        $this->expectException(NonExistentControllerException::class);

        $this->routeManager->get('/home', ['Wrong\\Controller\\', 'home']);
    }

    public function test_should_throw_an_exception_when_passing_an_invalid_controller_action(): void
    {
        $this->expectException(NonExistentActionException::class);

        $this->routeManager->get('/home', [SiteController::class, 'invalidAction']);
    }

    public function test_should_throw_an_exception_when_the_same_middleware_is_passed_twice(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->routeManager->get('/home', [SiteController::class, 'home'])
            ->setMiddlewares(
                Guest::class,
                Guest::class
            );
    }

    public static function assertRoute(Route $expected, Route $actual, string $message = ''): void
    {
        static::assertEquals($expected->method->name, $actual->method->name, $message . '. Error: method does not match');
        static::assertEquals($expected->path, $actual->path, $message . '. Error: path does not match');
        static::assertEquals($expected->controllerClass, $actual->controllerClass, $message . '. Error: controller class does not match');
        static::assertEquals($expected->actionName, $actual->actionName, $message . '. Error: action name does not match');
        static::assertEquals($expected->middlewares, $actual->middlewares, $message . '. Error: middlewares does not match');
    }
}
