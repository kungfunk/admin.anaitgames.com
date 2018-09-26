<?php
namespace Http\Actions\GetLogin;

use Http\Actions\Action;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Http\Actions\GetLogin\GetLoginResponder as Responder;

class GetLoginAction extends Action
{
    protected $responder;

    public function __invoke(Request $request, Response $response)
    {
        $this->responder = new Responder($this->view);
        $this->responder->setResponse($response);
        $this->responder->setOutput($this->output);
        return $this->responder->toHtml();
    }
}
