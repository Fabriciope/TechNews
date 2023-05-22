
<?php

require __DIR__ . "./vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(url(), "@");

$router->namespace("Source\Controllers");
$router->get("/", "IndexController@pageHome");
$router->get("/artigos", "IndexController@pageArticles");

// AUTH ROUTES
$router->get('/entrar', 'IndexController@pageLogin');

// PROFILE ROUTES
$router->group("/perfil");
$router->get("/", "UserController@pageProfile");
$router->get("/artigos-publicados", "UserController@pagePublishedArticles");
$router->get("/artigos-salvos", "UserController@pageSavedArticles");
$router->get("/novo-artigo", "UserController@pageNewArticle");

$router->group("error")->namespace("Source\Controllers");
$router->get("/{errcode}", "IndexController@error");


$router->post("/teste", "IndexController@teste");
$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}