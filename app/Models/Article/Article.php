<?php

namespace App\Models\Article;

use App\Core\Model;
use App\Support\Upload;
use App\Traits\ModelTrait;

use App\Models\Article\Paragraph;
use App\Models\User;

//use App\Interfaces\ModelInterface;

class Article extends Model
{
    use ModelTrait;

    protected static string $entity = 'articles';

    public function __construct()
    {
        parent::__construct(
            ['id', 'created_at', 'updated_at'],
            ['id_user', 'id_category', 'title', 'subtitle', 'uri', 'cover']
        );
    }

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



    public function author(?string $field = null)
    {
        if ($userId = $this->id_user) {
            $user = (new User)->findById($userId);

            if($field) return $user->$field;

            return $user;
        }
        return null;
    }

    public function category(?string $field = null)
    {
        if ($categoryId = $this->id_category) {
            $category = (new Category)->findById($categoryId);

            if($field) return $category->$field;

            return $category;
        }
        return null;
    }

    public function quantityComments(): int
    {
        //TODO: pagar a quantidade comentários que o artigos instanciado tem
        return 1; 
    }

    //TODO: ao invés de colocar update user colocar somente update, fazendo assim um polimorfismo, fazer também com os outros métodos dos outros modelos
    public function updateArticle(?array $coverData = null, ?array $titles = null, ?array $paragraphs = null): bool
    {
        $cover = empty($coverData['name']) ? null : $coverData;

        if (!$this->validateFields($cover)) {
            return false;
        }

        $findArticle = $this->find('uri = :uri AND id <> :id', "uri={$this->uri}&id={$this->id}")->fetch();
        if ($this->failed('Erro ao fazer a verificação do artigo')) return false;

        if ($findArticle) {
            $this->message->warning('Titulo de artigo indisponível');
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
            $paragraph = new Paragraph;
            //$paragraph->article_id = $this->id;
            if (!$paragraph->updateArticleParagraphs($this->id, $titles, $paragraphs)) return false;
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

    public function destroy(): bool
    {
        $paragraph = new Paragraph;
        $deleteParagraphs = $paragraph->deleteParagraphsByArticle($this->id);
        if (!$deleteParagraphs) {
            $this->message = $paragraph->message();
            return false;
        }
        if (!parent::destroy()) {
            $this->message->error('Erro ao deletar artigo');
            //if($this->failed('Erro ao deletar artigo')) return false;
            return false;
        }

        return true;
    }


    protected function validateFields(?array $coverData = null): bool
    {
        if (!$this->required('cover')) {
            $this->message->info('Preencha todos os campos requeridos');
            return false;
        }

        if (!is_urlEmbedYouTube($this->video)) {
            if (is_urlYouTube($this->video)) {
                $this->video = convertToYouTubeEmbedUrl($this->video);
            } else {
                $this->message->warning('Insira um link de compartilhamento do YouTube');
                return false;
            }
        }

        if ($coverData !== null) {
            if (!empty($coverData['name'])) {
                if ($cover = $coverData['tmp_name']) {
                    [$width, $height] = getimagesize($cover);
                    if ($height >= $width) {
                        $this->message->warning('Selecione uma imagem com as recomendações desejadas');
                        return false;
                    }
                }
            }
            if (empty($coverData['name'])) {
                $this->message->warning('Insira um imagem de capa');
                return false;
            }
        }

        return true;
    }
}
