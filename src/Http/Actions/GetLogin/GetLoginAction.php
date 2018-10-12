<?php
namespace Http\Actions\GetLogin;

use Http\Actions\Action;
use Slim\Http\Request;
use Slim\Http\Response;
use Http\Actions\GetLogin\GetLoginResponder as Responder;

class GetLoginAction extends Action
{
    protected $responder;

    public function __invoke(Request $request, Response $response)
    {
        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        return $this->responder->toHtml();
    }
}
