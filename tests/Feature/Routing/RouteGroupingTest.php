<?php

namespace Tests\Feature\Routing;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Src\Framework\Http\HttpMethods;
use Src\Framework\Http\Routing\Route;
use Src\Framework\Http\Routing\RouteManager;
use Src\Framework\Http\Routing\RouteRecorder;
use Src\Http\Controllers\API\AuthController;
use Src\Http\Controllers\Web\SiteController;
use Src\Http\Middlewares\Authenticate;
use Src\Http\Middlewares\Guest;

class RouteGroupingTest extends TestCase
{
    private RouteManager $routeManager;

    protected function setUp(): void
    {
        $this->routeManager = new RouteManager();
    }

    #[DataProvider('routeDataProvider')]
    public function test_if_grouped_routes_matches(Route $expectedRoute, $groupedRouteData): void
    {
        $this->routeManager->newGroup()
            ->setPrefix('user')
            ->setController(SiteController::class)
            ->group(function (RouteRecorder $route) {
                $route->get('/all', 'home');
                $route->post('/create', 'home');

                $route->newGroup()
                    ->setController(AuthController::class)
                    ->setMiddlewares(
                        Guest::class
                    )->group(function (RouteRecorder $route) {
                        $route->patch('/auth', 'test');
                        $route->delete('/auth/delete', 'test')
                            ->setMiddlewares(Authenticate::class);
                        $route->post('/auth/create', 'test');

                        $route->newGroup()
                            ->setPrefix('admin')
                            ->group(function (RouteRecorder $route) {
                                $route->get('/all/created', 'test');

                                $route->newGroup()
                                    ->setPrefix('allowed')
                                    ->setController(SiteController::class)
                                    ->group(function (RouteRecorder $route) {
                                        $route->post('/{adminId}/get', 'home');
                                    });
                            });
                    });
            });

        $routes = $this->routeManager->getRoutes();
        $this->assertIsArray($routes);
        foreach (['GET', 'POST', 'PATCH', 'DELETE'] as $methodName) {
            $this->assertNotEmpty($routes[$methodName]);
        }
        $this->assertEmpty($routes['PUT']);

        $message = 'this grouped routes dooes not match';
        [$methodName, $routeIndex] = $groupedRouteData;
        RouteCreationTest::assertRoute(
            $expectedRoute,
            $routes[$methodName][$routeIndex],
            $message
        );
    }

    public static function routeDataProvider(): array
    {
        return [
            [
                new Route(
                    path: '/user/all',
                    method: HttpMethods::GET,
                    controllerClass: SiteController::class,
                    actionName: 'home'
                ),
                ['GET', 0],
            ],
            [
                new Route(
                    method: HttpMethods::POST,
                    path: '/user/create',
                    controllerClass: sitecontroller::class,
                    actionName: 'home'
                ),
                ['POST', 0]
            ],
            [
                (new Route(
                    method: HttpMethods::PATCH,
                    path: '/user/auth',
                    controllerClass: AuthController::class,
                    actionName: 'test'
                ))->setMiddlewares(Guest::class),
                ['PATCH', 0]
            ],
            [
                (new Route(
                    method: HttpMethods::DELETE,
                    path: '/user/auth/delete',
                    controllerClass: AuthController::class,
                    actionName: 'test'
                ))->setMiddlewares(Guest::class, Authenticate::class),
                ['DELETE', 0]
            ],
            [
                (new Route(
                    method: HttpMethods::POST,
                    path: '/user/auth/create',
                    controllerClass: AuthController::class,
                    actionName: 'test'
                ))->setMiddlewares(Guest::class),
                ['POST', 1]
            ],
            [
                (new Route(
                    method: HttpMethods::GET,
                    path: '/user/admin/all/created',
                    controllerClass: AuthController::class,
                    actionName: 'test'
                ))->setMiddlewares(Guest::class),
                ['GET', 1]
            ],
            [
                (new Route(
                    method: HttpMethods::POST,
                    path: '/user/admin/allowed/{adminId}/get',
                    controllerClass: SiteController::class,
                    actionName: 'home'
                ))->setMiddlewares(Guest::class),
                ['POST', 2]
            ]
        ];
    }
}
