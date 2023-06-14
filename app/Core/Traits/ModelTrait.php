<?php

namespace App\Core\Traits;

use App\Core\Model;

trait ModelTrait
{
    
    public function findById(int $id, string $columns = '*'): ?Model
    {
        $fetch = $this->find('id = :id', "id={$id}", $columns)->fetch();
        
        if ($this->failed('Erro ao encontrar ' . static::$entity)) return null;

        return $fetch;
    }

    public function findByUri(string $uri, string $columns = '*'): ?Model
    {
        $article = $this->find('uri = :uri', "uri={$uri}", $columns)->fetch();

        if ($this->failed('Erro ao encontrar uri')) return null;

        return $article;
    }

    protected function failed(string $message): bool
    {
        if ($this->fail()) {
            $this->message->error($message);
            return true;
        }
        return false;
    }

    protected function uploadImage(
        string $imageField,
        array $imageData,
        int  $imageSize,
        string $imageDir,
        ?string $oldImagePath = null
    ): bool 
    {
        $upload = new \App\Support\Upload;
        $image = $upload->image(
            $imageData,
            $imageData['name'],
            $imageSize,
            $imageDir
        );
        if ($image === null) {
            $this->message = $upload->message();
            return false;
        }

        $oldImagePath = __DIR__ . "{$oldImagePath}{$this->$imageField}";
        if (is_file($oldImagePath) &&file_exists($oldImagePath)) {
            //@unlink()
            unlink($oldImagePath);
        }

        $this->$imageField = $image;
        return true;
    }
}
