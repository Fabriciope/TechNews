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

        $commentId = $this->create($this->safe());
        if($this->failed('Erro ao criar novo comentário')) return false;

        $this->data = ($this->findById($commentId))->data();
        return true;
    }

    public function validateFields(): bool
    {
        if(!$this->required()) {
            $this->message->info('Preencha todos os campos requeridos');
            return false;   
        }

        return true;
    }

}