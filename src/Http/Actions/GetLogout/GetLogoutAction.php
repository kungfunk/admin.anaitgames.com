<?php
namespace Http\Actions\GetLogout;

use Http\Actions\Action;
use Slim\Http\Request;
use Slim\Http\Response;

class GetLogoutAction extends Action
{
    protected $responder;

    public function __invoke(Request $request, Response $response)
    {
        $this->session->destroy();
        return $response->withRedirect($this->router->pathFor('login'));
    }
}
