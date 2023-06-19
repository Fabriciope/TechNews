<?php  

namespace App\Models\Article;

use App\Core\Database\Model;
use App\Core\Database\SupportModels;
use App\Support\MessageType;

/**
 * Model dos comentários
 */
class Comment extends Model
{
    use SupportModels;

    protected static string $entity = 'comments';
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['id_user', 'id_article', 'comment']
        );
    }
    
    /**
     * bootstrap
     *
     * @param  int $userId
     * @param  int $articleId
     * @param  string $comment
     * @return Comment
     */
    public function bootstrap(int $userId, int $articleId, string $comment): Comment
    {
        $this->id_user = $userId;
        $this->id_article = $articleId;
        $this->comment = $comment;

        return $this;
    }
    
    /**
     * createComment
     *
     * @return bool
     */
    public function createComment(): bool
    {
        if(!$this->validateFields()) {
            return false;
        }

        $article = (new Article)->findById($this->id_article);
        if($article->id_user ==  $this->id_user) {
            $this->message->make(MessageType::INFO, 'Você não pode comentar no próprio artigo');
            return false;
        }

        $commentId = $this->create($this->safe());
        if($this->failed('Erro ao criar novo comentário')) return false;

        $this->data = ($this->findById($commentId))->data();
        return true;
    }
    
    /**
     * user
     *
     * @param  ?string $field
     * @return mixed
     */
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
    
    /**
     * userComment
     *
     * @return bool
     */
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
    
    /**
     * validateFields
     *
     * @return bool
     */
    protected function validateFields(): bool
    {
        if(!$this->required()) {
            $this->message->make(MessageType::WARNING, 'Preencha todos os campos requeridos');
            return false;   
        }

        return true;
    }

}