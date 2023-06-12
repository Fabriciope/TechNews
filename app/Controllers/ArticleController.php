<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AuthUser;

class ArticleController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . './../../views/profile');
    }

    public function pagePublishedArticles(): void
    {
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $message->fixed()->flash();
            redirect('/perfil');
            return;
        }


        echo $this->views->render('published-articles', [
            'title' => 'Artigos publicados',
            'userData' => $user->data(),
            'publishedArticles' => static::getModel('Article')
                ->find( 
                'status = :status AND id_user = :userId',  
                "userId={$user->id}&status=published"
                )->order('published_at', 'DESC')->fetch(true)
        ]);
    }


    public function pageSavedArticles(): void
    {
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $message->fixed()->flash();
            redirect('/perfil');
            return;
        }

        echo $this->views->render('saved-articles', [
            'title' => 'Artigos salvos',
            'userData' => $user->data(),
            'savedArticles' => static::getModel('Article')
                ->find(
                'id_user = :userId AND status = :status', 
                "userId={$user->id}&status=created"
                )->order('created_at', 'DESC')->fetch(true)
        ]);

    }

    public function publishArticle(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $message->fixed()->flash();
            redirect('/perfil');
            return;
        }

        $articleUri = filter_var($data['articleUri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$articleUri || empty($articleUri)) {
            $this->message->error('Não foi possível encontrar artigo para exclusão')->flash();
            redirect('/perfil');
            return;
        }

        $article = static::getModel('Article')->findByUri($articleUri);
        $article->status = 'published';
        $article->published_at = date_fmt_datetime('now');
        if (!$article->updateArticle()) {
            $article->message()->fixed()->flash();
            redirect('/perfil/artigo/salvos');
            return;
        }

        $this->message->success('Artigo publicado com sucesso!')->fixed()->flash();
        redirect('/perfil/artigo/salvos');
    }

    public function pageEditArticle(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $message->fixed()->flash();
            redirect('/perfil');
            return;
        }

        $articleUri = filter_var($data['articleUri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $article = static::getModel('Article')->findByUri($articleUri);
        if (empty($data['articleUri']) || !$article) {
            $this->message->error('Artigo não encontrado para edição')->fixed()->flash();
            redirect('/perfil/artigo/salvos');
            return;
        }
        if ($article->id_user != $user->id) {
            $this->message->error('Você pode editar somente seus artigos')->fixed()->flash();
            redirect('/perfil/artigo/salvos');
            return;
        }


        $category = static::getModel('Category');
        $articleCategory = $category->findById($article->id_category)->category;
        $categoryOptionsWithSelection =  $category->selected($articleCategory)->getCategories();

        $paragraph = static::getModel('Paragraph');
        $articlesParagraphs = $paragraph->findParagraphsByArticleId($article->id);

        echo $this->views->render('new-article', [
            'title' => 'Editar ' . $article->title,
            'userData' => $user->data(),
            'articleData' => $article,
            'categoryOptions' => $categoryOptionsWithSelection,
            'articlesParagraphs' => $articlesParagraphs,
            'formAction' => 'alterar'
        ]);
    }
    
    public function updateArticle(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $message->fixed()->flash();
            redirect('/perfil');
            return;
        }

        if (!csrf_verify($data)) {
            $json['fixedMessage'] = $this->message->error('Favor use o formulário, ou recarregue a página')->fixed()->render();
            echo json_encode($json);
            return;
        }

        $articleUri = filter_var($data['articleUri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $article = static::getModel('Article')->findByUri($articleUri);
        $article->id_user = $user->id;
        $article->id_category = intval($data['category']);
        $article->title = str_title(trim($data['title']));
        $article->subtitle = ucfirst(trim($data['subtitle']));
        $article->uri = str_slug(trim($data['title']));
        $article->video = empty(trim($data['linkVideo'])) ? null : trim($data['linkVideo']);


        $paragraphsAndTitles = \App\Models\Article\Paragraph::getParagraphsAndTitles($data);
        if (isset($paragraphsAndTitles['position'])) {
            $position = $paragraphsAndTitles['position'];
            $json['fixedMessage'] = $this->message
                ->error("Insira um conteúdo ao {$position}° parágrafo")
                ->fixed()->render();

            echo json_encode($json);
            return;
        }

        extract($paragraphsAndTitles);
        if ($article->updateArticle($_FILES['cover'], $titles, $paragraphs)) {
            $this->message->success('Artigo alterado com sucesso!')->fixed()->flash();
            $json['redirect'] = url('/perfil/artigo/salvos');
        } else {
            $json['fixedMessage'] = $article->message()->fixed()->render();
        }

        echo json_encode($json);
        return;
    }

    public function deleteArticle(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $message->fixed()->flash();
            redirect('/perfil');
            return;
        }

        $articleUri = filter_var($data['articleUri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $article = static::getModel('Article')->findByUri($articleUri);
        if (empty($data['articleUri']) || !$article) {
            $this->message->error('Artigo não encontrado para exclusão')->fixed()->flash();
            redirect('/perfil/artigo/salvos');
            return;
        }
        if ($article->id_user != $user->id) {
            $this->message->error('Você pode deletar somente seus artigos')->fixed()->flash();
            redirect('/perfil/salvos');
            return;
        }
        
        if(!$article->destroy()) {
            $article->message()->fixed()->flash();
            redirect('/perfil/artigo/salvos');
            return;
        }

        $this->message->success('Artigo deletado com sucesso')->fixed()->flash();
        redirect('/perfil/artigo/salvos');
        return;
    }

    public function pageNewArticle(): void
    {
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $message->fixed()->flash();
            redirect('/perfil');
            return;
        }

        $categoryOptions = static::getModel('Category')->getCategories();

        echo $this->views->render('new-article', [
            'title' => 'Novo Artigo',
            'userData' => $user->data(),
            'categoryOptions' => $categoryOptions,
            'formAction' => 'criar'
        ]);
    }

    public function createArticle(array $data): void
    {
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $message->fixed()->flash();
            redirect('/perfil');
            return;
        }

        if (!csrf_verify($data)) {
            $json['fixedMessage'] = $this->message->error('Favor use o formulário, ou recarregue a página')->fixed()->render();
            echo json_encode($json);
            return;
        }

        $article = static::getModel('Article');
        $article->bootstrap(
            $user->id,
            intval($data['category']),
            str_title(trim($data['title'])),
            ucfirst(trim($data['subtitle'])),
            str_slug(trim($data['title'])),
            empty(trim($data['linkVideo'])) ? null : trim($data['linkVideo'])
        );

        $paragraphsAndTitles = \App\Models\Article\Paragraph::getParagraphsAndTitles($data);
        if (isset($paragraphsAndTitles['position'])) {
            $position = $paragraphsAndTitles['position'];
            $json['fixedMessage'] = $this->message
                    ->error("Insira um conteúdo ao {$position}° parágrafo")
                    ->fixed()->render();

            echo json_encode($json);
            return;
        }

        extract($paragraphsAndTitles);
        if ($article->createArticle($_FILES['cover'], $titles, $paragraphs)) {
            $this->message->success('Artigo criado com sucesso!')->fixed()->flash();
            $json['redirect'] = url('/perfil/artigo/salvos');
        } else {
            $json['fixedMessage'] = $article->message()->fixed()->render();
        }

        echo json_encode($json);
        return;
    }

    public function newComment(array $data): void
    {
        if(!csrf_verify($data)) {
            $json['message'] = $this->message->error('Favor use o formulário')->flash();
            echo json_encode($json);
            return;
        }

        //TODO: a pessoa não confirmada está conseguindo comentar (consertar)
        $user = AuthUser::authenticateUser(true);
        if($user instanceof \App\Support\Message) {
            $message = $user;
            $json['message'] = $message->before('Oops!')->fixed()->render();
            echo json_encode($json);
            return;
        }


        $articleId = filter_var($data['articleId'], FILTER_VALIDATE_INT);

        $comment = static::getModel('Comment')->bootstrap(
                $user->id,
                $articleId,
                trim($data['comment'])
            );

        if($comment->createComment()) {
            $this->message->success('Comentário realizado com sucesso!')->fixed()->flash();
            $articleUri = static::getModel('Article')->findById($articleId)->uri;
            $json['redirect'] = url("/artigo/{$articleUri}");
        } else {
            $json['message'] = $comment->message()->after('!')->render();
        }
        
        echo json_encode($json);
        return;
    }
}