<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Infrastructure\Exceptions\AuthenticationException;

use Domain\User\User;

class LoggedUserMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        if ($this->container->session->exists('user_id')) {
            $user = User::find($this->container->session->get('user_id'));
            if (!$user) {
                throw new AuthenticationException(AuthenticationException::INVALID_CREDENTIALS);
            }
            $this->container->loggedUser->set($user);
        }

        return $next($request, $response);
    }
}
