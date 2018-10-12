<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use Infrastructure\Exceptions\AuthenticationException;

use Models\User;

class LoggedUserMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        if ($this->container->get('session')->exists('user_id')) {
            $user = User::find($this->container->get('session')->get('user_id'));
            if (!$user) {
                throw new AuthenticationException(AuthenticationException::INVALID_CREDENTIALS);
            }
            $this->container->get('loggedUser')->set($user);
        }

        return $next($request, $response);
    }
}
