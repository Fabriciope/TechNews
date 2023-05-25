<?php

namespace Source\Traits;

use Source\Core\Model;

trait ModelTrait
{
    public function findById(int $id, string $columns = '*'): ?Model
    {
        $find = $this->find('id = :id', "id={$id}", $columns);
        return $find->fetch();
    }
}
