<?php

namespace Src\Support\FlashMessages;

/**
* Enum responsible for managing message types
*/
enum MessageType: string
{
    case SUCCESS = 'success';
    case INFO = 'info';
    case WARNING = 'warning';
    case ERROR = 'error';
}
