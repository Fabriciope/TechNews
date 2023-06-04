<?php

namespace App\Traits;

use App\Core\Model;

trait ModelTrait
{
    public function findById(?int $id, string $columns = '*'): ?Model
    {
        $find = $this->find('id = :id', "id={$id}", $columns);
        if($this->failed('Erro ao encontrar ' . static::$entity)) return null;

        return $find->fetch();

    }

    abstract private function validateFields();

    protected function failed(string $message): bool
    {
        if($this->fail()) {
            $this->message->error($message);
            return true;
        }
        return false;
    }

    protected function uploadImage(string $imageField, array $imageData, ?string $oldImagePath = null): bool
    {
        $upload = new \App\Support\Upload;
        $image = $upload->image(
            $imageData,
            $imageData['name'],
            CONF_IMAGE_COVER_SIZE,
            CONF_UPLOAD_COVER_DIR
        );
        if ($image === null) {
            $this->message = $upload->message();
            return null;
        }

        if(!empty($this->$imageField) && file_exists("{$oldImagePath}{$this->$imageField}")) {
            //@unlink()
            unlink("{$oldImagePath}{$this->$imageField}");
        }

        $this->$imageField = $image;
        return true;
    }
}
