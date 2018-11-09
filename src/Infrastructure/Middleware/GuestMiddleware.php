<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class GuestMiddleware extends Middleware
{
    const ERROR_MESSAGE = 'You must logoff first';

    public function __invoke(Request $request, Response $response, $next)
    {
        if ($this->container->has('user')) {
            $this->container->get('flash')->addMessage('error', self::ERROR_MESSAGE);
            return $response->withRedirect($this->container->get('router')->pathFor('dashboard'));
        }

        return $next($request, $response);
    }
}
