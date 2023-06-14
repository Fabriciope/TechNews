<?php  

namespace App\Models\Article;

use App\Core\Model;

use App\Core\Traits\ModelTrait;
use App\Support\MessageType;

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
            $this->message->make(MessageType::INFO, 'Você não pode comentar no próprio artigo');
            return false;
        }

        $this->id_article = $article->id;

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

    public function userComment(): bool
    {
        if($user = \App\Models\AuthUser::user()) {
            if($this->id_user == $user->id) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function getCommentsByArticleId(int $articleId, int $limit, int $offset): ?array
    {
        $articles = $this
            ->find('id_article = :articleId', "articleId={$articleId}")
            ->order('created_at', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->fetch(true);

        if($this->failed('Erro ao buscar comentários do artigo')) return null;

        return $articles;
    }

    protected function validateFields(): bool
    {
        if(!$this->required()) {
            $this->message->make(MessageType::WARNING, 'Preencha todos os campos requeridos');
            return false;   
        }

        return true;
    }

}