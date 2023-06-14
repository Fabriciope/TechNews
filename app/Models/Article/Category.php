<?php

namespace App\Models\Article;

use App\Core\Model;

use App\Core\Traits\ModelTrait;
use App\Support\MessageType;

class Category  extends Model
{
    use ModelTrait;

    protected static string $entity = 'categories';

    public ?string $selected = null;

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['category', 'uri']
        );
    }

    public function getCategories(): ?array
    {
        $fetchCategories = $this->find()->fetch(true);
        if($this->failed('Erro ao recuperar as categorias')) return null;
        
        if($this->selected) {
            foreach($fetchCategories as $category) {
                if($category->category == $this->selected) {
                    $category->selected = 'selected';
                }
            }
        }

        return $fetchCategories;
    }

    public function selected(string $category): Category
    {
        $this->selected = $category;
        return $this;
    }

    protected function validateFields(): bool
    {
        if(!$this->required()) {
            $this->message->make(MessageType::INFO, 'Preencha todos os campos');
            return false;
        }
        
        return true;
    }

}
