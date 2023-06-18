<?php

namespace App\Models\Article;

use App\Core\Database\Model;
use App\Core\Database\SupportModels;
use App\Models\User;
use App\Models\Article\Paragraph;
use App\Support\MessageType;

/**
 * Model do artigo
 */
class Article extends Model
{
    use SupportModels;

    protected static string $entity = 'articles';

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['id_user', 'id_category', 'title', 'subtitle', 'uri', 'cover']
        );
    }
    
    /**
     * bootstrap
     *
     * @return Article
     */
    public function bootstrap(
        int $id_user,
        int $id_category,
        string $title,
        string $subtitle,
        string $uri,
        ?string $video,
        ?string $cover = null,
    ): Article {
        $this->id_user = $id_user;
        $this->id_category = $id_category;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->uri = $uri;
        $this->cover = $cover;
        $this->video = $video;

        return $this;
    }
    
    /**
     * author
     *
     * @param  ?string $field
     * @return void
     */
    public function author(?string $field = null)
    {
        if ($userId = $this->id_user) {
            $user = (new User)->findById($userId);

            if($field) return $user->$field;

            return $user;
        }
        return null;
    }
    
    /**
     * category
     *
     * @param  ?string $field
     * @return void
     */
    public function category(?string $field = null)
    {
        if ($categoryId = $this->id_category) {
            $category = (new Category)->findById($categoryId);

            if($field) return $category->$field;

            return $category;
        }
        return null;
    }
    
    /**
     * amountOfComments
     *
     * @return int
     */
    public function amountOfComments(): int
    {
        $comment = new \App\Models\Article\Comment;
        return $comment->find('id_article = :id', "id={$this->id}")->count();
    }
    
    /**
     * updateArticle
     *
     * @param  ?array $coverData
     * @param  ?array $titles
     * @param  ?array $paragraphs
     * @return bool
     */
    public function updateArticle(?array $coverData = null, ?array $titles = null, ?array $paragraphs = null): bool
    {
        $cover = empty($coverData['name']) ? null : $coverData;
        
        if (!$this->validateFields($cover)) {
            return false;
        }

        $findArticle = $this->find('uri = :uri AND id <> :id', "uri={$this->uri}&id={$this->id}")->fetch();
        if ($this->failed('Erro ao fazer a verificação do artigo, tente novamente mais tarde')) return false;

        if ($findArticle) {
            $this->message->make(MessageType::WARNING, 'Titulo de artigo indisponível');
            return false;
        }

        if ($cover) {
            if (!$this->uploadImage(
                'cover',
                $cover,
                CONF_IMAGE_COVER_SIZE,
                CONF_UPLOAD_COVER_DIR,
                './../..'
            )) return false;
        }

        if ($paragraphs) {
            if (!(new Paragraph)->updateArticleParagraphs($this->id, $titles, $paragraphs)) return false;
        }

        $this->update(
            $this->safe(),
            'id = :id',
            "id={$this->id}"
        );
        if ($this->failed('Erro ao alterar artigo')) return false;

        $this->data = ($this->findById($this->id))->data();
        return true;
    }
    
    /**
     * createArticle
     *
     * @param  array $coverData
     * @param  ?array $titles
     * @param  array $paragraphs
     * @return bool
     */
    public function createArticle(array $coverData, ?array $titles, array $paragraphs): bool
    {
        if (!$this->validateFields($coverData)) {
            return false;
        }

        if (!$this->uploadImage(
            'cover',
            $coverData,
            CONF_IMAGE_COVER_SIZE,
            CONF_UPLOAD_COVER_DIR,
            __DIR__ . "./../.."
        )) return false;

        if ($this->findByUri($this->uri)) {
            $this->message->make(MessageType::WARNING, 'Já existe um artigo com este titulo')->fixed()->render();
            return false;
        }

        $articleId = $this->create($this->safe());
        if ($this->failed('Erro ao criar um novo artigo')) return false;

        $paragraph = new Paragraph;
        if (!$paragraph->createArticleParagraphs($articleId, $titles, $paragraphs)) {
            $this->message = $paragraph->message();
            return false;
        }

        $this->data = ($this->findById($articleId))->data();
        return true;
    }
    
    /**
     * destroy
     *
     * @return bool
     */
    public function destroy(): bool
    {
        if (!(new Paragraph)->delete('id_article', $this->id)) {
            $this->message->make(MessageType::ERROR, 'Erro ao excluir parágrafos do artigo');
            return false;
        }
        
        if(!(new Comment)->delete('id_article', $this->id)) {
            $this->message->make(MessageType::ERROR, 'Erro ao excluir comentários do artigo');
            return false;
        }
        
        if (!parent::destroy()) {
            $this->message->make(MessageType::ERROR, 'Erro ao deletar artigo');
            return false;
        }

        return true;
    }

    
    /**
     * validateFields
     *
     * @param  ?array $coverData
     * @return bool
     */
    protected function validateFields(?array $coverData = null): bool
    {
        $ignore = $coverData ? 'cover' : null;
        if (!$this->required($ignore)) {
            $this->message->make(MessageType::INFO, 'Preencha todos os campos requeridos');
            return false;
        }

        if (!is_urlEmbedYouTube($this->video)) {
            if (is_urlYouTube($this->video)) {
                $this->video = convertToYouTubeEmbedUrl($this->video);
            } else {
                $this->message->make(MessageType::WARNING, 'Insira um link de compartilhamento do YouTube');
                return false;
            }
        }

        if ($coverData !== null) {
            if (!empty($coverData['name'])) {
                if ($cover = $coverData['tmp_name']) {
                    [$width, $height] = getimagesize($cover);
                    if ($height >= $width) {
                        $this->message->make(MessageType::WARNING, 'Selecione uma imagem com as recomendações desejadas');
                        return false;
                    }
                }
            } else {
                $this->message->make(MessageType::WARNING, 'Insira um imagem de capa');
                return false;
            }
        }

        return true;
    }
}
