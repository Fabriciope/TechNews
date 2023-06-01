<?php

namespace App\Traits;

use App\Core\Model;

trait ModelTrait
{
    public function findById(?int $id, string $columns = '*'): ?Model
    {
        $find = $this->find('id = :id', "id={$id}", $columns);
        return $find->fetch();
        if($this->fail()) {
            $this->message->error('Erro ao encontrar usuário');
            return null;
        }
    }
}
