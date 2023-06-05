<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article\Article;
use App\Models\Article\Paragraph;

use App\Models\User;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../../views');
    }

    public function pageHome()
    {
        echo $this->views->render('home', [
            'title' => 'TechNews',
            'articles' => (new Article)
                ->find('status = :s', 's=published')
                ->order('published_at', 'DESC')
                ->limit(6)
                ->fetch(true)
        ]);
    }

    public function pageArticlePost(array $data): void
    {

        $article = (new Article)->findByUri($data['articleUri'] ?? '');
        if(!$article) {
            redirect('/404');
            return;
        }

        $article->views += 1;
        $article->updateArticle();

        echo $this->views->render('article-post', [
            'title' => $article->title,
            'article' => $article,
            'paragraphs' => (new Paragraph)->findParagraphsByArticleId($article->id),
            'relatedArticles' => $article->findRelatedArticlesByCategory($article->id_category, $article->id) ?? []
        ]);
    }

    public function pageUser(): void
    {
        echo $this->views->render('user', [
            'title' => 'Nome usuário'
        ]);
    }

    public function pageArticles()
    {
        $article = new Article;
        echo $this->views->render('articles', [
            'title' => 'Artigos',
            'relevanteArticles' => $article
                ->find('status = :s', 's=published')
                ->order('views', 'DESC')
                ->limit(3)
                ->fetch(true),
            'articles' => $article
                ->find('status = :s', 's=published')
                ->order('published_at', 'DESC')
                ->limit(9)
                ->fetch(true)
        ]);
    }

    public function pageLogin(): void
    {
        if(\App\Models\AuthUser::user()) {
            redirect('/perfil');
        }
        echo $this->views->render('auth-login', [
            'title' => 'Entrar',
            'rememberEmail' => filter_input(INPUT_COOKIE, 'authEmail')
        ]);
    }

    public function pageRegister(): void
    {
        if(\App\Models\AuthUser::user()) {
            redirect('/perfil');
        }
        echo $this->views->render('auth-register', [
            'title' => 'Cadastrar',
        ]);
    }

    public function pageForgetPassword(): void
    {
        echo $this->views->render('auth-forget-password', [
            'title' => 'Recuperar senha'
        ]);
    }

    public function pageResetPassword(): void
    {
        echo $this->views->render('auth-reset-password', [
            'title' => 'Redefinir senha'
        ]);
    }




    public function error(array $data)
    {
        var_dump($data);
    }
}
