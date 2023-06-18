<?php

namespace App\Core;

use App\Core\ViewsEngine;
use App\Support\Message;
use App\Support\MessageType;

/**
 * Classe abstrata do controller
 */
abstract class Controller
{
    protected Message $message;
    
    /**
     * __construct
     *
     * @param  ViewsEngine $views
     * @return void
     */
    public function __construct( protected ViewsEngine $views)
    {
        $this->views->addFolder('layouts', __DIR__ . '/../../views/layouts')
                    ->addFolder('includes', __DIR__ . '/../../views/includes');
        
        $this->message = new Message;
    }
    
    /**
     * getModel
     *
     * @param  string $model
     * @return App\Core\Model
     */
    protected static function getModel(string $model): \App\Core\Model
    {
        if(str_contains($model, 'User')) {
            $class = "\\App\\Models\\" . ucfirst($model);
            return new $class;
        } else {
            $class = "\\App\\Models\\Article\\" . ucfirst($model);
            return new $class;
        }
    }

    /**
     * checkRequest
     *
     * @param  array $request
     * @return bool
     */
    protected function checkRequest(array $request): bool
    {
        if(!csrf_verify($request)) {
            echo json_encode([
                'fixedMessage' => $this->message->make(MessageType::ERROR, 'Favor use o formulário!')->render(true)
            ]);
            return false;
        }
        
        return true;
    }
}