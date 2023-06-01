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

    public function findParagraphsByArticle(int $articleId)
    {
        $fetchParagraphs = $this->find('id_article = :id', "id={$articleId}")->fetch(true);
        var_dump($fetchParagraphs);
    }
}