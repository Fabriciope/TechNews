<?php

namespace App\Support;

use CoffeeCode\Uploader\Image;
use App\Support\MessageType;

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

        if (in_array('', $image)) {
            $this->message->make(MessageType::WARNING, 'Esta imagem não pode ser carregada');
            return null;
        }
        
        $uploadImage = new Image(__DIR__ . './../..' . CONF_UPLOAD_DIR, $dir);
        if (!in_array($image['type'], $uploadImage::isAllowed())) {
            $this->message->make(MessageType::WARNING, 'Insira uma imagem com a extensão válida');
            return null;
        }
        
        $path = $uploadImage->upload($image, $name, $width, CONF_IMAGE_QUALITY);
        $startSavedPath = strpos($path, CONF_UPLOAD_DIR);
        return mb_substr($path, $startSavedPath);
    }
}
