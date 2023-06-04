<?php

namespace App\Support;

use CoffeeCode\Uploader\Image;

class Upload
{
    private Message $message;

    public function __construct()
    {
        $this->message = new Message;
    }

    public function message(): Message
    {
        return $this->message;
    }

    public function image(
        array $image,
        string $name,
        int $width,
        string $dir = CONF_UPLOAD_IMAGE_DIR
    ): ?string 
    {
        
        // if (!empty($image['name']) && (empty($image['tmp_name']) || empty($image['type']))) {
        //     $this->message->warning('Esta foto não pode ser carregada');
        //     return null;
        // }

        if (in_array('', $image)) {
            $this->message->warning('Esta imagem não pode ser carregada');
            return null;
        }
        
        $uploadImage = new Image(__DIR__ . './../..' . CONF_UPLOAD_DIR, $dir);
        if (!in_array($image['type'], $uploadImage::isAllowed())) {
            $this->message->warning('Insira uma imagem com a extensão válida');
            return null;
        }
        
        $path = $uploadImage->upload($image, $name, $width, CONF_IMAGE_QUALITY);
        $startSavedPath = strpos($path, CONF_UPLOAD_DIR);
        return mb_substr($path, $startSavedPath);
    }
}
