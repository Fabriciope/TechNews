<?php

namespace App\Support;

/**
 * Enum responsável por gerenciar os tipos de mensagem
 */
enum MessageType: string
{
    case SUCCESS = 'success';
    case INFO = 'info';
    case WARNING = 'warning';
    CASE ERROR = 'error';
}