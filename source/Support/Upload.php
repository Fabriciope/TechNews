<?php

namespace Source\Support;

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
        $uploadImage = new Image(__DIR__ . "./../.." . CONF_UPLOAD_DIR, $dir);

        if (empty($image['type']) || !in_array($image['type'], $uploadImage::isAllowed())) {
            $this->message->warning('Insira uma imagem válida');
            return null;
        }

        $pathOr = $uploadImage->upload($image, $name, $width, CONF_IMAGE_QUALITY);
        $startSavePath = strpos($pathOr, CONF_UPLOAD_DIR);
        return mb_substr($pathOr, $startSavePath);
    }
}
