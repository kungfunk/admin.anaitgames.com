<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthMiddleware extends Middleware
{
    const ERROR_MESSAGE = 'You must login first';

    public function __invoke(Request $request, Response $response, $next)
    {
        if (!$this->container->loggedUser->isAuth()) {
            $this->container->flash->addMessage('error', self::ERROR_MESSAGE);
            return $response->withRedirect($this->container->router->pathFor('login'));
        }

        return $next($request, $response);
    }
}
