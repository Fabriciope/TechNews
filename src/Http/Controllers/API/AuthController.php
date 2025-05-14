<?php

namespace Src\Http\Controllers\API;

use Src\Framework\Core\Controller\APIController;
use Fabriciope\Router\Request\Request;

class AuthController extends APIController
{
    public function test(Request $request): void
    {
        echo json_encode([
            'error' => false,
        ]);
    }
}
