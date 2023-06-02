<?php

namespace App\Models\Article;

use App\Core\Model;

class Paragraph extends Model
{
    protected static string $entity = 'paragraphs';

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['id_article', 'paragraph', 'position']
        );
    }

    public function addParagraph(
        int $id_article,
        string $paragraph,
        int $position,
        ?string $title = null
    ): bool
    {

        // verificação desnecessária
        // if(empty($paragraph)) {
        //     $this->message->error("Insira um conteúdo ao parágrafo {$position}");
        //     return false;
        // }
        $this->id_article = $id_article;
        $this->paragraph = $paragraph;
        $this->position = $position;
        $this->title = $title;


        $this->create($this->safe());
        if($this->fail()) {
            $this->message->error('Erro ao adicionar um novo parágrafo');
            return false;
        }

        return true;
    }

    public function findParagraphsByArticleId(int $articleId)
    {
        return $this->find('id_article = :id', "id={$articleId}")
        ->order('position', 'ASC')
        ->fetch(true);
    }

    public function deleteParagraphsByArticle(int $articleId): bool
    {
        $this->delete('id_article', $articleId);
        if($this->fail()) {
            $this->message->error("Erro ao excluir parágrafos do artigo");
            return false;
        }

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
                        $titles[$position] = $content;
                        break;
                    case 'contentParagraph':
                        if (empty($content)) {
                            return ['position' => $position];
                        }
                        $paragraphs[$position] = $content;
                        break;
                }
            }
        }

        return [
            'titles' => $titles,
            'paragraphs' => $paragraphs
        ];
    }
}