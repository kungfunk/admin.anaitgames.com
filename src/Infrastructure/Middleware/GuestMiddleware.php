<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Infrastructure\Exceptions\NotAuthorizedException;

class GuestMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        try {
            if ($this->container->loggedUser->isAuth()) {
                throw new NotAuthorizedException(NotAuthorizedException::USER_IS_LOGGED_IN);
            }
        } catch (\Exception $exception) {
            $this->container->flash->addMessage('error', $exception->getMessage());
            return $response->withRedirect($this->container->router->pathFor('dashboard'));
        }

        return $next($request, $response);
    }
}
