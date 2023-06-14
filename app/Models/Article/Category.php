<?php

namespace App\Models\Article;

use App\Core\Model;

use App\Core\Traits\ModelTrait;
use App\Support\MessageType;

class Category  extends Model
{
    use ModelTrait;

    protected static string $entity = 'categories';

    public mixed $selected = null;

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['category', 'uri']
        );
    }

    public function getCategories(): ?array
    {
        $categories = $this->find()->fetch(true);
        if($this->failed('Erro ao recuperar as categorias')) return null;
        
        if($this->selected) {
            foreach($categories as $category) {
                if($category->id == $this->selected) {
                    $category->selected = 'selected';
                }
            }
        }

        return $categories;
    }

    public function selected(int $categoryId): Category
    {
        $this->selected = $categoryId;
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
