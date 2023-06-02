<?php

namespace App\Models\Article;

use App\Core\Model;
use App\Support\Upload;
use App\Traits\ModelTrait;

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

    public function findByUri(string $uri, string $columns = '*'): ?Article
    {
        $find = $this->find('uri = :uri', "uri={$uri}", $columns);
        return $find->fetch();
    }

    public function findArticlesByUser(int $userId): array
    {
        $find = $this->find("id_user = :userId", "userId={$userId}");
        return $find->fetch(true);
    }

    public function findUserSavedArticles(int $userId): ?array
    {
       return $this->find(
            'id_user = :userId AND status = :status', 
            "userId={$userId}&status=created"
        )->fetch(true);
    }

    public function updateArticle(?array $coverData = null, ?array $titles = null, ?array $paragraphs = null): bool
    {
        $cover = empty($coverData['name']) ? null : $coverData;
        if (!$this->validateFields($cover, $this->video)) {
            return false;
        }

        $findArticle = $this->find('uri = :uri AND id <> :id', "uri={$this->uri}&id={$this->id}")->fetch();
        if($this->fail()) {
            $this->message->error('Erro ao fazer a verificação do artigo');
            // $this->message->error($this->fail());
            return false;
        }
        if($findArticle) {
            $this->message->warning('Titulo de artigo indisponível');
            return false;
        }

        if(!empty($cover['name'])) {
            unlink(__DIR__ . "./../../.." . $this->cover);
            if(!$this->uploadCover($coverData)) return false;
        }

        if(!$this->updateArticleParagraphs($titles, $paragraphs)) return false;

        $this->update(
            $this->safe(),  
            'id = :id',
            "id={$this->id}"
        );
        if($this->fail()) {
            $this->message->error('Erro ao alterar artigo');
            return false;
        }

        $this->data = ($this->findById($this->id))->data();
        return true;
    }

    public function createArticle(array $coverData, ?array $titles, array $paragraphs): bool
    {
        if (!$this->validateFields($coverData, $this->video)) {
            return false;
        }

        if(!$this->uploadCover($coverData)) return false;

        $articleId = $this->create($this->safe());
        if ($this->fail()) {
            $this->message->error('Erro ao criar um novo artigo');
            return false;
        }

        if(!$this->createArticleParagraphs($articleId, $titles, $paragraphs)) return false;

        $this->data = ($this->findById($articleId))->data();
        return true;
    }

    private function createArticleParagraphs(int $articleId, array $titles, $paragraphs): bool
    {
        $paragraph = new Paragraph;
        foreach($paragraphs as $position => $paragraphContent) {
            if (!empty($titles[$position])) {
                $newParagraph = $paragraph->addParagraph(
                    $articleId,
                    $paragraphContent,
                    intval($position),
                    $titles[$position]
                );
                if (!$newParagraph) {
                    $this->message = $paragraph->message();
                    return false;
                }
            } else {
                $newParagraph = $paragraph->addParagraph(
                    $articleId,
                    $paragraphContent,
                    intval($position),
                );
                if (!$newParagraph) {
                    $this->message = $paragraph->message();
                    return false;
                }
            }
        }

        return true;
    }

    private function updateArticleParagraphs(array $titles, array $paragraphs): bool
    {
        $paragraph = new Paragraph;
        $deletedParagraphs = $paragraph->deleteParagraphsByArticle($this->id);
        if(!$deletedParagraphs) {
            $this->message = $paragraph->message();
            return false;
        }

        return $this->createArticleParagraphs($this->id, $titles, $paragraphs);
    }

    private function uploadCover(array $cover): bool
    {
        $upload = new Upload;
        $image = $upload->image(
            $cover,
            $cover['name'],
            CONF_IMAGE_COVER_SIZE,
            CONF_UPLOAD_COVER_DIR
        );
        if ($image === null) {
            $this->message = $upload->message();
            return false;
        }
        $this->cover = $image;

        return true;
    }

    private function validateFields(?array $coverData = null, ?string $videoLink = null): bool
    {
        if (!$this->required('cover')) {
            $this->message->info('Preencha todos os campos requeridos');
            return false;
        }
        
        if ($videoLink) {
            if (!is_urlYouTube($this->video)) {
                $this->message->warning('Insira um link de compartilhamento do YouTube');
                return false;
            } else {
                $this->video = convertYouTubeUrl($this->video);
            }
        }
        if ($coverData !== null) {
            if (!empty($coverData['name'])) {
                [$width, $height] = getimagesize($coverData['tmp_name']);
                if ($height >= $width) {
                    $this->message->warning('Selecione uma imagem com as recomendações desejadas');
                    return false;
                }
            }
            if(empty($coverData['name'])) {
                $this->message->warning('Insira um imagem de capa');
                return false;
            }
        }

        return true;
    }
}
