<?php

namespace App\Models\Article;

use App\Core\Model;
use App\Traits\ModelTrait;

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

    public function getCategories(): array
    {
        $fetchCategories = $this->find()->fetch(true);
        if($this->selected) {
            //array_search()
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

}
