<?php  

namespace App\Models\Article;

use App\Core\Model;
use App\Traits\ModelTrait;

class Comment extends Model
{
    use ModelTrait;

    protected static string $entity = 'comments';

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['id_user', 'id_article', 'comment']
        );
    }

    public function bootstrap(int $userId, int $articleId, string $comment): Comment
    {
        $this->id_user = $userId;
        $this->id_article = $articleId;
        $this->comment = $comment;

        return $this;
    }

    public function createComment(): bool
    {
        if(!$this->validateFields()) {
            return false;
        }

        $article = (new Article)->findById($this->id_article);
        if($article->id ==  $this->id_user) {
            $this->message->info('Você não pode comentar no próprio artigo');
            return false;
        }

        $this->id_article = $article->id;
        //TODO: fazer a verificação se o artigo foi encontrado

        $commentId = $this->create($this->safe());
        if($this->failed('Erro ao criar novo comentário')) return false;

        $this->data = ($this->findById($commentId))->data();
        return true;
    }

    public function user(?string $field = null): mixed
    {
        if($user = $this->id_user) {
            $user = (new \App\Models\User)->findById($this->id_user);
            if($field) return $user->$field;
            
            return $user;
        }

        if($field) {
            return $user->$field;
        }

        return null;
    }

    public function getCommentsByArticleId(int $articleId): ?array
    {
        $articles = $this->find('id_article = :articleId', "articleId={$articleId}")->fetch(true);

        if($this->failed('Erro ao buscar comentários do artigo')) return null;

        return $articles;
    }

    public function validateFields(): bool
    {
        if(!$this->required()) {
            $this->message->warning('Preencha todos os campos requeridos');
            return false;   
        }

        return true;
    }

}