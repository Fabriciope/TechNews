<?php

namespace App\Support;

use CoffeeCode\Uploader\Image;
use App\Support\MessageType;

/**
 * Classe responsável por fazer o upload de arquivos
 */
class Upload
{
    private Message $message;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->message = new Message;
    }
    
    /**
     * message
     *
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }
    
    /**
     * image
     *
     * @param array $image
     * @param string $name
     * @param int $width
     * @param string $dir
     * @return void
     */
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
            $this->message->make(MessageType::INFO, 'Insira uma imagem com a extensão válida');
            return null;
        }
        
        $path = $uploadImage->upload($image, $name, $width, CONF_IMAGE_QUALITY);
        $startSavedPath = strpos($path, CONF_UPLOAD_DIR);
        return mb_substr($path, $startSavedPath);
    }
}
