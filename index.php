<?php

require __DIR__ . "./vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(url(), "@");

$router->namespace("Source\Controllers");
$router->get("/", "IndexController@pageHome");
$router->post("/teste", "IndexController@teste");
$router->get("/artigos", "IndexController@pageArticles");

$router->group("/perfil");
$router->get("/", "UserController@pageProfile");
$router->get("/novo-artigo", "UserController@pageNewArticle");

$router->group("error")->namespace("Source\Controllers");
$router->get("/{errcode}", "IndexController@error");


$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}