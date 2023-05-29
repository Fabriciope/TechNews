<?php

namespace App\Models;

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
        string $title = null,
        string $paragraph,
        int $position
    ): bool
    {
        $this->id_article = $id_article;
        $this->title = $title;
        $this->paragraph = $paragraph;
        $this->position = $position;

        $this->create($this->safe());
        if(!$this->fail()) {
            $this->message->error('Erro ao adicionar um novo parágrafo');
            return false;
        }

        return true;
    }
}