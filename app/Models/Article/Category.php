<?php

namespace App\Models\Article;

use App\Core\Database\Model;
use App\Core\Database\SupportModels;
use App\Support\MessageType;

/**
 * Model da categoria
 */
class Category  extends Model
{
    use SupportModels;

    protected static string $entity = 'categories';

    public mixed $selected = null;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['category', 'uri']
        );
    }
    
    /**
     * getCategories
     *
     * @return ?array
     */
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
    
    /**
     * selected
     *
     * @param  int $categoryId
     * @return Category
     */
    public function selected(int $categoryId): Category
    {
        $this->selected = $categoryId;
        return $this;
    }
    
    /**
     * validateFields
     *
     * @return bool
     */
    protected function validateFields(): bool
    {
        if(!$this->required()) {
            $this->message->make(MessageType::INFO, 'Preencha todos os campos');
            return false;
        }
        
        return true;
    }

}
