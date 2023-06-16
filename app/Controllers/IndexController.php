<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Support\Message;
use App\Support\MessageType;
use App\Support\Paginator;

/**
 * Controller principal, onde estão as rotas padrões, que não incluem muita complexidade da regra de negócio
 */
class IndexController extends Controller
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new \App\Core\ViewsEngine(__DIR__ . '/../../views'));
    }

    /**
     * > Method => GET
     * Página Home
     *
     * @return void
     */
    public function pageHome(): void
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

    public function pageAbout(): void
    {
        echo $this->views->render('about', [
            'title' => 'Sobre nós'
        ]);
    }

    /**
     * > Method => GET 
     * Página onde estão todos os artigos publicados e os mais visualizados
     *
     * @param  array $data 
     * @return void
     */
    public function pageArticles(array $data): void
    {
        $article = static::getModel('Article');

        $paginator = new Paginator(
            6,
            isset($data['page']) ? intval($data['page']) : 1,
            '/artigos/',
            $article->count()
        );

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
            'paginator' => $paginator
        ]);
    }

    /**
     * > Method => GET
     * Página do artigo com o conteúdo do mesmo, artigos relacionados e todos os seus comentários 
     *
     * @param  array $data
     * @return void
     */
    public function pageArticlePost(array $data): void
    {
        $user = \App\Models\AuthUser::user();

        $articleUri = filter_var($data['articleUri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $article = static::getModel('Article')->findByUri($articleUri);
        if (!$article) {
            redirect('/404');
            return;
        }

        if ($user) {
            if ($article->id_user != $user->id) {
                $article->views += 1;
            }
        } else {
            $article->views += 1;
        }
        $article->updateArticle();

        $comment = static::getModel('Comment');
        $comment->find('id_article = :articleId', "articleId={$article->id}");
        $paginator = new Paginator(
            2,
            isset($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1,
            "artigo/{$article->uri}/",
            $comment->count()
        );

        echo $this->views->render('article-post', [
            'title' => $article->title,
            'articleData' => $article,
            'paragraphs' => static::getModel('Paragraph')->findParagraphsByArticleId($article->id),
            'relatedArticles' => $article
                ->find(
                    'id_category = :category AND id <> :id AND status = :status',
                    "category={$article->id_category}&id={$article->id}&status=published"
                )->order('rand()')
                ->limit(3)
                ->fetch(true),
            'comments' => $comment->getCommentsByArticleId($article->id, $paginator->limit(), $paginator->offset()),
            'userArticle' => is_null($user) ? false : ($user->id == $article->id_user),
            'commentPagination' => $paginator,
        ]);
    }

    /**
     * > Method => POST / GET
     * Página onde todos os artigos encontrados são listados, a partir de um pesquisa
     *
     * @param  array $data
     * @return void
     */
    public function searchArticle(array $data): void
    {
        if (!empty($data['search'])) {
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

        $paginator = new Paginator(
            6,
            $page,
            "artigos/{$search}",
            $findArticles->count()
        );
        echo $this->views->render('articles-found', [
            'title' => $search,
            'search' => $search,
            'articlesFound' => $findArticles
                ->order('published_at', 'DESC')
                ->limit($paginator->limit())
                ->offset($paginator->offset())
                ->fetch(true),
            'paginator' => $paginator
        ]);
    }

    /**
     * > Method => GET
     * Página que faz a listagem dos artigos de uma determinada categoria
     *
     * @param  array $data
     * @return void
     */
    public function pageCategoryArticles(array $data): void
    {
        $categoryUri = filter_var($data['uri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $category = static::getModel('Category')->findByUri($categoryUri);
        $categoryArticles = static::getModel('Article')->find('id_category = :categoryId AND status = :status', "categoryId={$category->id}&status=published");

        $paginator = new Paginator(
            9,
            isset($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1,
            "/artigos/categoria/{$category->uri}",
            $categoryArticles->count()
        );
        echo $this->views->render('articles-found', [
            'title' => $category->category,
            'category' => $category->category,
            'search' => false,
            'articlesFound' => $categoryArticles
                ->order('published_at', 'DESC')
                ->limit($paginator->limit())
                ->offset($paginator->offset())
                ->fetch(true),
            'paginator' => $paginator
        ]);
    }

    /**
     * > Method => GET
     * Página com as informações sobre um determinado usuário
     *
     * @param  array $data
     * @return void
     */
    public function pageUser(array $data): void
    {
        $userId = $data['userId'] ?? null;
        $user = static::getModel('User')->findById($userId);
        if (!$user) {
            $this->message->make(MessageType::ERROR, 'Erro ao encontrar usuário')->flash(true);
            back();
            return;
        }

        $findArticles = static::getModel('Article')->find(
            'id_user = :userId AND status = :status',
            "userId={$userId}&status=published"
        );

        $paginator = new Paginator(
            6,
            isset($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1,
            "/usuario/{$userId}/",
            $findArticles->count()
        );

        $userArticles = null;
        if (count($findArticles->fetch(true)) >= 1) {
            $userArticles = $findArticles
                ->order('published_at', 'DESC')
                ->limit($paginator->limit())
                ->offset($paginator->offset())
                ->fetch(true);
        }
        echo $this->views->render('user', [
            'title' => "{$user->first_name} {$user->last_name}",
            'user' => $user,
            'userArticles' => $userArticles,
            'paginator' => $paginator,
        ]);
    }

    /**
     * > Method => GET
     * Página de login
     *
     * @return void
     */
    public function pageLogin(): void
    {
        if (\App\Models\AuthUser::user()) {
            redirect('/perfil');
        }

        echo $this->views->render('auth-login', [
            'title' => 'Entrar',
            'rememberEmail' => filter_input(INPUT_COOKIE, 'authEmail')
        ]);
    }

    /**
     * > Method => GET
     * Página de cadastro
     *
     * @return void
     */
    public function pageRegister(): void
    {
        if (\App\Models\AuthUser::user()) {
            redirect('/perfil');
        }

        echo $this->views->render('auth-register', [
            'title' => 'Cadastrar',
        ]);
    }

    /**
     * > Method => GET
     * Página de recuperação de senha
     *
     * @return void
     */
    public function pageForgetPassword(): void
    {
        if (\App\Models\AuthUser::user()) {
            redirect('/perfil');
        }
        
        echo $this->views->render('auth-forget-password', [
            'title' => 'Recuperar senha'
        ]);
    }
    
    /**
     * > Method => GET
     * Página para alterar a senha
     *
     * @return void
     */
    public function pageResetPassword(): void
    {
        echo $this->views->render('auth-reset-password', [
            'title' => 'Redefinir senha'
        ]);
    }
    
    /**
     * > Method => GET
     * Página de erros
     *
     * @param  array $data
     * @return void
     */
    public function error(array $data): void
    {
        $error = new \stdClass();

        switch ($data["errcode"]) {
            case "problemas":
                $error->code = "OPS";
                $error->message = "Parece que nosso serviço está indisponível no momento. Já estamos vendo isso mas :/";
                $error->linkTitle = "Enviar e-mail";
                $error->link = "mailto:" . CONF_MAIL_SENDER['address'];
                break;
            case "manutencao":
                $error->code = "OPS";
                $error->message = "Voltamos logo. Por hora estamos trabalhando para melhorar nosso conteúdo para você controlar melhor as suas contas :P";
                $error->linkTitle = null;
                $error->link = null;
                break;
            default:
                $error->code = $data["errcode"];
                $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido :/";
                $error->linkTitle = "Continue navegando";
                $error->link = url_back();
                break;
        }

        echo $this->views->render("error", [
            "title" => "{$data['errcode']} | OOPS!",
            "error" => $error
        ]);
    }
}
