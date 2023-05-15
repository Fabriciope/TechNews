<?php

require __DIR__ . "./vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(CONF_URL_BASE, "@");

$router->namespace("Source\Controllers");
$router->get("/", "IndexController@home");

$router->group("error")->namespace("Test");
$router->get("/{errcode}", "Coffee:notFound");


$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}