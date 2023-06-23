<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AuthUser;
use App\Support\MessageType;

/**
 * ArticleController
 */
class ArticleController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new \App\Core\ViewsEngine(__DIR__ . './../../views/profile'));
    }

    /**
     * > Method => POST
     * Controller responsável por fazer a publicação de um artigo salvo
     *
     * @param  array $data
     * @return void
     */
    public function publishArticle(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if (!$user) return;

        $articleId = filter_var($data['articleId'], FILTER_VALIDATE_INT);
        $article = static::getModel('Article')->findById($articleId);
        if (!$article) {
            $this->message->make(MessageType::ERROR, 'Não foi possível encontrar artigo para publicação')->flash(true);
            redirect('/perfil/artigo/salvos');
            return;
        }

        $article->status = 'published';
        $article->published_at = date_fmt('now', 'Y-m-d H:i:s');
        if (!$article->updateArticle()) {
            $article->message()->flash(true);
            redirect('/perfil/artigo/salvos');
            return;
        }

        $this->message->make(MessageType::SUCCESS, 'Artigo publicado com sucesso!')->flash(true);
        redirect('/perfil/artigo/publicados');
    }

    /**
     * > Method => GET
     * Página responsável por carregar os dodos de um artigo para edição
     *
     * @param  mixed $data
     * @return void
     */
    public function pageEditArticle(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if (!$user) return;

        $articleUri = filter_var($data['articleUri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $article = static::getModel('Article')->findByUri($articleUri);
        if (!$article) {
            $this->message->make(MessageType::ERROR, 'Artigo não encontrado para edição')->flash(true);
            redirect('/perfil/artigo/salvos');
            return;
        }
        if ($article->id_user != $user->id) {
            $this->message->make(MessageType::INFO, 'Você pode editar somente seus artigos')->flash(true);
            redirect('/perfil/artigo/salvos');
            return;
        }

        echo $this->views->render('new-article', [
            'title' => 'Editar ' . $article->title,
            'userData' => $user->data(),
            'articleData' => $article,
            'categoryOptions' => static::getModel('Category')
                ->selected($article->id_category)
                ->getCategories(),
            'articlesParagraphs' => static::getModel('Paragraph')->findParagraphsByArticleId($article->id),
            'formAction' => 'alterar'
        ]);
    }

    /**
     * > Method => POST
     * Controller responsável por fazer a edição de um artigo
     *
     * @param  array $data
     * @return void
     */
    public function updateArticle(array $data): void
    {
        if (!$this->checkRequest($data)) return;

        $user = AuthUser::authenticateUser(true, json: true);
        if (!$user) return;

        $articleId = filter_var($data['articleId'], FILTER_VALIDATE_INT);
        $article = static::getModel('Article')->findById($articleId);
        if ($article->id_user != $user->id) {
            $this->message->make(MessageType::ERROR, "Você pode editar apenas os seus artigos!")->flash(true);
            echo json_encode(['redirect' => url('/perfil/artigo/salvos')]);
            return;
        }
        $article->id_user = $user->id;
        $article->id_category = intval($data['category']);
        $article->title = str_title(trim($data['title']));
        $article->subtitle = ucfirst(trim($data['subtitle']));
        $article->uri = str_slug(trim($data['title']));
        $article->video = empty($data['linkVideo']) ? null : trim($data['linkVideo']);

        $paragraphsAndTitles = \App\Models\Article\Paragraph::getParagraphsAndTitles($data);
        if (isset($paragraphsAndTitles['error'])) {
            $error = $paragraphsAndTitles['error'];
            $json['fixedMessage'] = $this->message
                ->make(MessageType::WARNING, $error)
                ->render(true);
            echo json_encode($json);
            return;
        }

        extract($paragraphsAndTitles);
        if ($article->updateArticle($_FILES['cover'], $titles, $paragraphs)) {
            $this->message->make(MessageType::SUCCESS, 'Artigo alterado com sucesso!')->flash(true);
            $json['redirect'] = url('/perfil/artigo/salvos');
        } else {
            $json['fixedMessage'] = $article->message()->render(true);
        }

        echo json_encode($json);
        return;
    }

    /**
     * > Method => POST
     * Controller responsável por deletar um artigo
     *
     * @param  array $data
     * @return void
     */
    public function deleteArticle(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if (!$user) return;

        $articleId = filter_var($data['articleId'], FILTER_VALIDATE_INT);
        $article = static::getModel('Article')->findById($articleId);
        if ($article->id_user != $user->id) {
            $this->message->make(MessageType::ERROR, 'Você pode deletar somente seus artigos')->flash(true);
            redirect('/perfil/artigo/salvos');
            return;
        }

        if (!$article->destroy()) {
            $article->message()->flash(true);
            redirect('/perfil/artigo/salvos');
            return;
        }

        $this->message->make(MessageType::SUCCESS, 'Artigo deletado com sucesso')->flash(true);
        redirect('/perfil/artigo/salvos');
        return;
    }

    /**
     * > Method => GET
     * Página para criação de novo artigo
     *
     * @return void
     */
    public function pageNewArticle(): void
    {
        $user = AuthUser::authenticateUser(true);
        if (!$user) return;

        $categoryOptions = static::getModel('Category')->getCategories();

        echo $this->views->render('new-article', [
            'title' => 'Novo Artigo',
            'userData' => $user->data(),
            'categoryOptions' => $categoryOptions,
            'formAction' => 'criar'
        ]);
    }

    /**
     * > Method => POST
     * createArticle
     *
     * @param  array $data
     * @return void
     */
    public function createArticle(array $data): void
    {
        if (!$this->checkRequest($data)) return;

        $user = AuthUser::authenticateUser(true, json: true);
        if (!$user) return;

        $article = static::getModel('Article')
            ->bootstrap(
                $user->id,
                intval($data['category']),
                str_title(trim($data['title'])),
                ucfirst(trim($data['subtitle'])),
                str_slug(trim($data['title'])),
                empty(trim($data['linkVideo'])) ? null : trim($data['linkVideo'])
            );

        $paragraphsAndTitles = \App\Models\Article\Paragraph::getParagraphsAndTitles($data);
        if (isset($paragraphsAndTitles['error'])) {
            $error = $paragraphsAndTitles['error'];
            $json['fixedMessage'] = $this->message
                ->make(MessageType::WARNING, $error)
                ->render(true);

            echo json_encode($json);
            return;
        }

        extract($paragraphsAndTitles);
        if ($article->createArticle($_FILES['cover'], $titles, $paragraphs)) {
            $this->message->make(MessageType::SUCCESS, 'Artigo criado com sucesso!')->flash(true);
            $json['redirect'] = url('/perfil/artigo/salvos');
        } else {
            $json['fixedMessage'] = $article->message()->render(true);
        }

        echo json_encode($json);
        return;
    }

    /**
     * > Method => POST
     * Controller responsável por criar um comentário em algum artigo
     *
     * @param  array $data
     * @return void
     */
    public function newComment(array $data): void
    {
        if (!$this->checkRequest($data)) return;

        $user = AuthUser::authenticateUser(true, json: true);
        if (!$user) return;

        $articleId = filter_var($data['articleId'], FILTER_VALIDATE_INT);
        $comment = static::getModel('Comment')
            ->bootstrap(
                $user->id,
                $articleId,
                trim($data['comment'])
            );

        if ($comment->createComment()) {
            $this->message->make(MessageType::SUCCESS, 'Comentário realizado com sucesso!')->flash(true);
            $articleUri = static::getModel('Article')->findById($articleId)->uri;
            $json['redirect'] = url("/artigo/{$articleUri}");
        } else {
            $json['message'] = $comment->message()->after('!')->render();
        }

        echo json_encode($json);
        return;
    }

    /**
     * > Method => POST
     * Controller responsável por deletar um comentário
     *
     * @param  array $data
     * @return void
     */
    public function deleteComment(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if (!$user) return;

        $commentId = filter_var($data['commentId'], FILTER_VALIDATE_INT);
        $comment = static::getModel('Comment')->findById($commentId);
        if (!$comment) {
            $this->message->make(MessageType::ERROR, 'Comentário não encontrado para exclusão')->flash(true);
            back();
        }
        if($comment->id_user != $user->id) {
            $this->message->make(MessageType::ERROR, 'Você pode deletar somente seus comentários')->flash(true);
            back();
            return;
        }


        $comment->destroy();
        $this->message->make(MessageType::SUCCESS, 'Comentário excluído com sucesso')->flash(true);
        back();
    }
}
