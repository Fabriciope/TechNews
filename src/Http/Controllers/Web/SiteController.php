<?php

namespace Src\Http\Controllers\Web;

use Src\Core\Controller\WebController;
use Src\Core\Request\Request;
use Src\Http\Requests\TestRequest;
use Src\Http\Response;

class SiteController extends WebController
{
    public function __construct()
    {
        parent::__construct();
        parent::setUpTemplatesEngine(__DIR__ . '/../../../../resources/templates/views/site');
    }

    public function home(Request $request): void
    {
        echo $this->renderTemplate('home', ['title' => env('APP_NAME')]);
    }

    public function test(TestRequest $request): void
    {
        dd($request->getServerVar('HTTP_REFERER'));
        Response::redirect('/');
    }

    public function otherTest(Request $request): void
    {
        dd(file_get_contents('php://input'), $_SERVER, $_POST);

        //dd($request->getPathVar('name'), $request->getMethodName(), $request->getBodyVar('email', 'default value'), $_POST);
    }

    public function otherTest2(Request $request): void
    {
        dd($request->bodyData);

        //dd($request->getPathVar('name'), $request->getMethodName(), $request->getBodyVar('email', 'default value'), $_POST);
    }
}
