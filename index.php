<?php

require __DIR__ . './vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(url(), '@');

// WEB ROUTES
$router->namespace('Source\Controllers');
$router->get('/', 'IndexController@pageHome');

$router->get('/teste', 'IndexController@teste2');

// ARTICLES ROUTES
$router->group('/artigos');
$router->get('/', 'IndexController@pageArticles');
$router->get('/{uri}', 'IndexController@pageArticlePost');

$router->group(null);
$router->get('/usuario/{userUri}', 'IndexController@pageUser');


// AUTH ROUTES
$router->get('/entrar', 'IndexController@pageLogin');
$router->post('/entrar', 'AuthController@login');

$router->get('/cadastrar', 'IndexController@pageRegister');
$router->post('/cadastrar', 'AuthController@register');

$router->get('/recuperar-senha', 'IndexController@pageForgetPassword');
$router->post('/recuperar-senha', 'AuthController@forgetPassword');
$router->get('/redefinir-senha/{code}', 'AuthController@pageResetPassword');
$router->post('/redefinir-senha', 'AuthController@resetPassword');

// OPTIN
$router->get('/confirma', 'AuthController@pageConfirmEmail');
$router->get("/obrigado/{email}", 'AuthController@pageConfirmedEmail');

// PROFILE ROUTES
$router->group('/perfil');
$router->get('/', 'UserController@pageProfile');
$router->get('/artigos-publicados', 'UserController@pagePublishedArticles');
$router->get('/artigos-salvos', 'UserController@pageSavedArticles');
$router->get('/novo-artigo', 'UserController@pageNewArticle');

$router->group('error')->namespace('Source\Controllers');
$router->get('/{errcode}', 'IndexController@error');


$router->post('/teste', 'IndexController@teste');
$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}