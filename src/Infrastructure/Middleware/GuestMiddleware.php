<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GuestMiddleware extends Middleware
{
    const ERROR_MESSAGE = 'You must logoff first';

    public function __invoke(Request $request, Response $response, $next)
    {
        if ($this->container->loggedUser->isAuth()) {
            $this->container->flash->addMessage('error', self::ERROR_MESSAGE);
            return $response->withRedirect($this->container->router->pathFor('dashboard'));
        }

        return $next($request, $response);
    }
}
