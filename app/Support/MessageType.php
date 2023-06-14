<?php

namespace App\Support;

enum MessageType: string
{
    case SUCCESS = 'success';
    case INFO = 'info';
    case WARNING = 'warning';
    CASE ERROR = 'error';
}