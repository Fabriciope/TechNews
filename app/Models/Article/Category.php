<?php

namespace App\Models\Article;

use App\Core\Model;

class category  extends Model
{
    private static string $entity = 'categories';

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['category', 'uri']
        );
    }
    public function selected(string $category)
    {
        
    }
}
