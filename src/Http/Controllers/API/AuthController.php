<?php

namespace Src\Http\Controllers\API;

use Src\Core\Controller\APIController;
use Src\Http\Requests\Request;

class AuthController extends APIController
{
    public function test(Request $request): void
    {
        echo json_encode([
            'error' => false,
        ]);
    }
}
