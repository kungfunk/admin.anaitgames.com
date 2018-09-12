<?php
namespace Http\Actions\Dashboard;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DashboardAction
{
    protected $responder;

    public function __invoke(Request $request, Response $response)
    {
        echo "hola";
    }
}
