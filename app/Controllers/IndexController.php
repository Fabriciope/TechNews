<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Support\Message;
use App\Support\MessageType;
use App\Support\Paginator;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct(new \App\Core\ViewsEngine(__DIR__ . '/../../views') );
    }

    public function pageHome()
    {
        echo $this->views->render('home', [
            'title' => 'TechNews',
            'articles' => static::getModel('Article')
                ->find('status = :s', 's=published')
                ->order('published_at', 'DESC')
                ->limit(6)
                ->fetch(true)
        ]);
    }

    public function pageArticles(array $data): void
    {
        $article = static::getModel('Article');

        $page = isset($data['page']) ? intval($data['page']) : 1;
        $paginator = new Paginator(6, $page, $article->count());

        echo $this->views->render('articles', [
            'title' => 'Artigos',
            'relevantArticles' => $article
                ->find('status = :s', 's=published')
                ->order('views', 'DESC')
                ->limit(3)
                ->fetch(true),
            'articles' => $article
                ->find('status = :s', 's=published')
                ->order('published_at', 'DESC')
                ->limit($paginator->limit())
                ->offset($paginator->offset())
                ->fetch(true),
            'paginator' => $paginator,
            'uri' => '/artigos'
        ]);
    }

    public function pageArticlePost(array $data): void
    {
        $user = \App\Models\AuthUser::user();

        $article = static::getModel('Article')->findByUri($data['articleUri'] ?? '');
        if(!$article) {
            redirect('/404');
            return;
        }

        
        if($user) {
            if($article->id_user != $user->id) {
                $article->views += 1;
            }
        } else {
            $article->views += 1;
        }
        $article->updateArticle();
        
        $page = isset($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1;
        
        
        $comment = static::getModel('Comment'); 
        $comment->find('id_article = :articleId', "articleId={$article->id}");
        $paginator = new Paginator(2, $page, $comment->count());

        echo $this->views->render('article-post', [
            'title' => $article->title,
            'articleData' => $article,
            'paragraphs' => static::getModel('Paragraph')->findParagraphsByArticleId($article->id),
            'relatedArticles' => $article->find('id_category = :c AND id <> :id', "c={$article->id_category}&id={$article->id}")
                ->order('rand()')
                ->limit(3)
                ->fetch(true),
            'comments' => $comment->getCommentsByArticleId($article->id, $paginator->limit(), $paginator->offset()),
            'userArticle' => is_null($user) ? false : ($user->id == $article->id_user),
            'commentPagination' => $paginator,
            'paginatorUri' => "artigo/{$article->uri}"
        ]);
    }

    public function searchArticle(array $data): void
    {
        if(!empty($data['search'])) {
            $search = filter_var($data['search'], FILTER_DEFAULT);
            echo json_encode(['redirect' => url("/artigos/buscar/{$search}/1")]);
            return;
        }

        $search = filter_var($data['terms'] ?? '', FILTER_DEFAULT);
        $page = filter_var($data['page'], FILTER_VALIDATE_INT) >= 1 ? $data['page'] : 1;

            
        
        $findArticles = static::getModel('Article')->find(
            'MATCH(title, subtitle) AGAINST(:search) AND status = :status',
            "search={$search}&status=published"
        );

        $paginator = new Paginator(6, $page, $findArticles->count());
        echo $this->views->render('articles-found', [
            'title' => $search,
            'search' => $search,
            'paginationUri' => "artigos/{$search}",
            'paginator' => $paginator,
            'articlesFound' => $findArticles
                ->limit($paginator->limit())
                ->offset($paginator->offset())
                ->fetch(true)
        ]);
    }

    public function pageCategoryArticles(array $data): void
    {
        $categoryUri = filter_var($data['uri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $page = isset($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1;

        $category = static::getModel('Category')->findByUri($categoryUri);
        $categoryArticles = static::getModel('Article')->find('id_category = :categoryId AND status = :status', "categoryId={$category->id}&status=published");

        $paginator = new Paginator(9, $page, $categoryArticles->count());
        echo $this->views->render('articles-found', [
            'title' => $category->category,
            'category' => $category->category,
            'search' => false,
            'paginationUri' => "/artigos/categoria/{$category->uri}",
            'paginator' => $paginator,
            'articlesFound' => $categoryArticles
                ->limit($paginator->limit())
                ->offset($paginator->offset())
                ->order('published_at', 'DESC')
                ->fetch(true)
        ]);
    }

    public function pageUser(array $data): void
    {
        $userId = $data['userId'] ?? null;
        $user = static::getModel('User')->findById($userId);
        if(!$user) {
            $this->message->make(MessageType::ERROR, 'Erro ao encontrar usuário')->flash(true);
            back();
            return;
        }

        $findArticles = static::getModel('Article')->find('id_user = :userId', "userId={$userId}");
        
        $page = isset($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1;
        $paginator = new Paginator(6, $page, $findArticles->count());

        $userArticles = null;
        if(count($findArticles->fetch(true)) >= 1) {
            $userArticles = $findArticles
                    ->limit($paginator->limit())
                    ->offset($paginator->offset())
                    ->fetch(true);
        }
        echo $this->views->render('user', [
            'title' => "{$user->first_name} {$user->last_name}",
            'user' => $user,
            'userArticles' => $userArticles,
            'paginator' => $paginator,
            'paginatorUri' => "/usuario/{$userId}",
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
}
