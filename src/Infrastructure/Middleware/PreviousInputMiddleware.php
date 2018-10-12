<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class PreviousInputMiddleware extends Middleware
{
    private const INDEX_NAME = 'previousInput';

    public function __invoke(Request $request, Response $response, $next)
    {
        $this->container->get('view')->getEnvironment()->addGlobal(
            self::INDEX_NAME,
            $this->container->get('session')->get(self::INDEX_NAME)
        );

        $this->container->get('session')->set(self::INDEX_NAME, $request->getParams());

        return $next($request, $response);
    }
}
