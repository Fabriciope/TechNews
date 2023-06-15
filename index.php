<?php

require __DIR__ . './vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(url(), '@');

// WEB ROUTES
$router->namespace('App\Controllers');
$router->get('/', 'IndexController@pageHome');

// ARTICLES ROUTES
$router->group('artigo');
$router->get('/{articleUri}', 'IndexController@pageArticlePost');
$router->get('/{articleUri}/{page}', 'IndexController@pageArticlePost');
$router->post('/novo-comentario', 'ArticleController@newComment');
$router->post('/deletar-comentario', 'ArticleController@deleteComment');

$router->group('/artigos');
$router->get('/', 'IndexController@pageArticles');
$router->get('/{page}', 'IndexController@pageArticles');

$router->post('/buscar', 'IndexController@searchArticle');
$router->get('/buscar/{terms}/{page}', 'IndexController@searchArticle');

$router->get('/categoria/{uri}', 'IndexController@pageCategoryArticles');
$router->get('/categoria/{uri}/{page}', 'IndexController@pageCategoryArticles');

$router->group(null);
$router->get('/usuario/{userId}', 'IndexController@pageUser');
$router->get('/usuario/{userId}/{page}', 'IndexController@pageUser');




// AUTH ROUTES
$router->get('/entrar', 'IndexController@pageLogin');
$router->post('/entrar', 'AuthController@login');

$router->get('/cadastrar', 'IndexController@pageRegister');
$router->post('/cadastrar', 'AuthController@register');

$router->get('/recuperar-senha', 'IndexController@pageForgetPassword');
$router->post('/recuperar-senha', 'AuthController@forgetPassword');
$router->get('/redefinir-senha/{code}', 'AuthController@pageResetPassword');
$router->post('/redefinir-senha', 'AuthController@resetPassword');

$router->get('/sair', 'AuthController@logout');


// OPTIN
$router->get('/confirma', 'AuthController@pageConfirmEmail');
$router->get("/obrigado/{email}", 'AuthController@pageConfirmedEmail');

// PROFILE ROUTES
$router->group('/perfil');
$router->get('/', 'UserController@pageProfile');
$router->post('/atualizar', 'UserController@updateProfile');


// ARTICLES ACTIONS
$router->group('perfil/artigo');

$router->get('/salvos', 'UserController@pageSavedArticles');
$router->get('/salvos/{page}', 'UserController@pageSavedArticles');

$router->post('/publicar', 'ArticleController@publishArticle');
$router->post('/deletar', 'ArticleController@deleteArticle');

$router->get('/publicados', 'UserController@pagePublishedArticles');
$router->get('/publicados/{page}', 'UserController@pagePublishedArticles');

$router->get('/novo', 'ArticleController@pageNewArticle');
$router->post('/criar', 'ArticleController@createArticle');
$router->get('/editar/{articleUri}', 'ArticleController@pageEditArticle');
$router->post('/alterar', 'ArticleController@updateArticle');



$router->group('error')->namespace('App\Controllers');
$router->get('/{errcode}', 'IndexController@error');


$router->post('/teste', 'IndexController@teste');
$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}