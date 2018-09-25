<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PreviousInputMiddleware extends Middleware
{
    private const INDEX_NAME = 'previousInput';

    public function __invoke(Request $request, Response $response, $next)
    {
        $previousInput = array_key_exists(self::INDEX_NAME, $_SESSION) ? $_SESSION[self::INDEX_NAME] : null;

        $this->container->view->getEnvironment()->addGlobal(self::INDEX_NAME, $previousInput);
        $_SESSION['previousInput'] = $request->getParams();

        return $next($request, $response);
    }
}
