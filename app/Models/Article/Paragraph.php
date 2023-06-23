<?php

namespace App\Models\Article;

use App\Core\Database\ActiveRecord;
use App\Core\Database\SupportModels;
use App\Support\MessageType;

/**
 * Model dos parágrafos
 */
class Paragraph extends ActiveRecord
{
    use SupportModels;

    protected static string $entity = 'paragraphs';

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['id_article', 'paragraph', 'position']
        );
    }

    /**
     * findParagraphsByArticleId
     *
     * @param  int $articleId
     * @return ?array
     */
    public function findParagraphsByArticleId(int $articleId): ?array
    {
        $paragraphs = $this->find('id_article = :id', "id={$articleId}")
            ->order('position', 'ASC')
            ->fetch(true);

        if ($this->failed('Erro ao buscar parágrafos do artigo')) return null;

        return $paragraphs;
    }

    /**
     * addParagraph
     *
     * @param int $id_article
     * @param string $paragraph
     * @param int $position
     * @return bool
     */
    public function addParagraph(
        int $articleId,
        string $paragraph,
        int $position,
        ?string $title = null
    ): bool {
        $this->id_article = $articleId;
        $this->paragraph = $paragraph;
        $this->position = $position;
        $this->title = $title;

        if (!$this->validateFields()) return false;

        $this->create($this->safe());
        if ($this->failed('Erro ao adicionar um novo parágrafo')) return false;

        return true;
    }

    /**
     * getParagraphsAndTitles
     *
     * @param  array $data
     * @return array
     */
    public static function getParagraphsAndTitles(array $data): array
    {
        $titles =  [];
        $paragraphs = [];
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

    /**
     * createArticleParagraphs
     *
     * @param  int $articleId
     * @param  ?array $titles
     * @param  array $paragraphs
     * @return bool
     */
    public function createArticleParagraphs(int $articleId, ?array $titles, array $paragraphs): bool
    {
        foreach ($paragraphs as $position => $paragraphContent) {
            if (isset($titles[$position]) && !empty($titles[$position])) {
                $newParagraph = $this->addParagraph(
                    $articleId,
                    trim($paragraphContent),
                    intval($position),
                    trim($titles[$position])
                );
                if (!$newParagraph) return false;
            } else {
                $newParagraph = $this->addParagraph(
                    $articleId,
                    trim($paragraphContent),
                    intval($position),
                );
                if (!$newParagraph) return false;
            }
        }
        
        return true;
    }

    /**
     * updateArticleParagraphs
     *
     * @param  int $articleId
     * @param  array $titles
     * @param  array $paragraphs
     * @return bool
     */
    public function updateArticleParagraphs(int $articleId, array $titles, array $paragraphs): bool
    {
        $this->delete('id_article', $articleId);
        if ($this->failed('Erro ao excluir parágrafos do artigo')) return false;

        return $this->createArticleParagraphs($articleId, $titles, $paragraphs);
    }

    /**
     * deleteParagraphsByArticle
     *
     * @param  int $articleId
     * @return bool
     */
    public function deleteParagraphsByArticle(int $articleId): bool
    {
        $this->delete('id_article', $articleId);
        if ($this->failed('Erro ao excluir parágrafos do artigo')) return false;

        return true;
    }

    /**
     * validateFields
     *
     * @return bool
     */
    protected function validateFields(): bool
    {
        if (!$this->required()) {
            $this->message->make(MessageType::INFO, 'Preencha todos os campos do parágrafo');
            return false;
        }

        if(is_string($this->title)) {
            if(mb_strlen($this->title) < 5) {
                $this->message->make(MessageType::WARNING, 'Insira um título com no mínimo 5 caracteres');
                return false;
            }
        }
        
        if(mb_strlen($this->paragraph) < 10) {
            $this->message->make(MessageType::WARNING, 'Insira um paragrafo com no mínimo 10 caracteres');
            return false;
        }

        return true;
    }
}
