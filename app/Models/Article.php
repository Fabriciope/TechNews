<?php

namespace App\Models;

use App\Core\Model;
use App\Support\Upload;

class Article extends Model
{
    protected static string $entity = 'articles';

    public function __construct()
    {
        parent::__construct(
            ['id', 'published_at'],
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

    public function findByUri(string $uri, string $columns = '*')
    {
        $find = $this->find('uri = :uri', "uri={$uri}", $columns);
        return $find->fetch();
    }

    public function findArticlesByUser(int $userId): array
    {
        $find = $this->find("id_user = :userId", "userId={$userId}");
        return $find->fetch(true);
    }

    public function createArticle(array $cover, array $titles, array $paragraphs): bool
    {
        if (!$this->validateFields($cover)) {
            return false;
        }

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

        $articleId = $this->create($this->safe());
        if ($this->fail()) {
            $this->message->error('Erro ao criar um novo artigo');
            return false;
        }

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
                    $json['fixedMessage'] = $this->message()->$paragraph->message();
                    return false;
                }
            } else {
                $newParagraph = $paragraph->addParagraph(
                    $articleId,
                    $paragraphContent,
                    intval($position),
                );
                if (!$newParagraph) {
                    $json['fixedMessage'] = $this->message()->$paragraph->message();
                    return false;
                }
            }
        }

        return true;
    }

    public function validateFields(?array $cover = null): bool
    {
        if (!$this->required('cover')) {
            $this->message->info('Preencha todos os campos requeridos');
            return false;
        }
        
        if (!isset($this->id) && !is_null($this->video)) {
            if (!is_urlYouTube($this->video)) {
                $this->message->warning('Insira um link de compartilhamento do YouTube');
                return false;
            } else {
                $this->video = convertYouTubeUrl($this->video);
            }
        }
        if ($cover) {
            if (!empty($cover['name'])) {
                [$width, $height] = getimagesize($cover['tmp_name']);
                if ($height >= $width) {
                    $this->message->warning('Selecione uma imagem com as recomendações desejadas');
                    return false;
                }
            }
            if(empty($cover['name'])) {
                $this->message->warning('Insira um imagem de capa');
                return false;
            }
        }
        

        return true;
    }
}
