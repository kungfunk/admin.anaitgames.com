<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PreviousInputMiddleware extends Middleware
{
    private const INDEX_NAME = 'previousInput';

    public function __invoke(Request $request, Response $response, $next)
    {
        $this->container->view->getEnvironment()->addGlobal(
            self::INDEX_NAME,
            $this->container->session->get(self::INDEX_NAME)
        );

        $this->container->session->set(self::INDEX_NAME, $request->getParams());

        return $next($request, $response);
    }
}
