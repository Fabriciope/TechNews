<?php

require __DIR__ . './vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(url(), '@');

// WEB ROUTES
$router->namespace('App\Controllers');
$router->get('/', 'IndexController@pageHome');

$router->get('/teste', 'IndexController@teste2');

// ARTICLES ROUTES
// TODO: fazer as rotas de pesquisa e paginação 
$router->get('/artigo/{articleUri}', 'IndexController@pageArticlePost');
$router->group('/artigos');
$router->get('/', 'IndexController@pageArticles');
$router->get('/{page}', 'IndexController@pageArticles');
$router->post('/pesquisar', 'IndexController@searchArticle');

//TODO: fazer pesquisa por categoria
$router->get('/categoria/{categoryId}', 'IndexController@pageCategoryArticles');
$router->get('/categoria/{categoryId}/{page}', 'IndexController@pageCategoryArticles');

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

$router->get('/salvos', 'ArticleController@pageSavedArticles');
$router->post('/publicar', 'ArticleController@publishArticle');
$router->post('/deletar', 'ArticleController@deleteArticle');
$router->get('/publicados', 'ArticleController@pagePublishedArticles');
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