<?php

namespace App\Models\Article;

use App\Core\Model;
use App\Core\Traits\ModelTrait;
use App\Support\MessageType;

class Paragraph extends Model
{
    use ModelTrait;

    protected static string $entity = 'paragraphs';

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['id_article', 'paragraph', 'position']
        );
    }
    
    public function findParagraphsByArticleId(int $articleId): ?array
    {
        $paragraphs = $this->find('id_article = :id', "id={$articleId}")
        ->order('position', 'ASC')
        ->fetch(true);

        if($this->failed('Erro ao buscar parágrafos do artigo')) return null;

        return $paragraphs;
    }

    public function addParagraph(
        int $id_article,
        string $paragraph,
        int $position,
        ?string $title = null
    ): bool
    {
        $this->id_article = $id_article;
        $this->paragraph = $paragraph;
        $this->position = $position;
        $this->title = $title;

        if(!$this->validateFields()) return false;

        $this->create($this->safe());
        if($this->failed('Erro ao adicionar um novo parágrafo')) return false;

        return true;
    }

    public static function getParagraphsAndTitles(array $data): array
    {
        $titles =  array();
        $paragraphs =  array();
        foreach ($data as $field => $content) {
            if (str_contains($field, 'Paragraph')) {
                list($type, $position) = explode('-', $field);
                switch ($type) {
                    case 'titleParagraph':
                        $titles[$position] = filter_var($content, FILTER_SANITIZE_SPECIAL_CHARS);
                        break;
                    case 'contentParagraph':
                        if (empty($content)) {
                            return ['position' => $position];
                        }
                        $paragraphs[$position] = filter_var($content, FILTER_SANITIZE_SPECIAL_CHARS);
                        break;
                }
            }
        }

        return [
            'titles' => $titles,
            'paragraphs' => $paragraphs
        ];
    }

    public function createArticleParagraphs(int $articleId, array $titles, $paragraphs): bool
    {
        foreach($paragraphs as $position => $paragraphContent) {
            if (isset($titles[$position]) && !empty($titles[$position])) {
                $newParagraph = $this->addParagraph(
                    $articleId,
                    trim($paragraphContent),
                    intval($position),
                    trim($titles[$position])
                );
                if (!$newParagraph) {
                    return false;
                }
            } else {
                $newParagraph = $this->addParagraph(
                    $articleId,
                    trim($paragraphContent),
                    intval($position),
                );
                if (!$newParagraph) {
                    return false;
                }
            }
        }

        return true;
    }

    public function updateArticleParagraphs(int $articleId, array $titles, array $paragraphs): bool
    {
        if(!$this->deleteParagraphsByArticle($articleId)) {
            return false;
        }

        return $this->createArticleParagraphs($articleId, $titles, $paragraphs);
    }

    public function deleteParagraphsByArticle(int $articleId): bool
    {
        $this->delete('id_article', $articleId);
        if($this->failed('Erro ao excluir parágrafos do artigo')) return false;

        return true;
    }

    protected function validateFields(): bool
    {
        if(!$this->required()) {
            $this->message->make(MessageType::INFO, 'Preencha todos os campos do parágrafo');
            return false;
        }
        return true;
    }
}