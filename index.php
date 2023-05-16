<?php

require __DIR__ . "./vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(url(), "@");

$router->namespace("Source\Controllers");
$router->get("/", "IndexController@home");
$router->get("/artigos", "IndexController@pageArticles");

$router->group("error")->namespace("Test");
$router->get("/{errcode}", "Coffee:notFound");


$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}