<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use Infrastructure\Exceptions\AuthenticationException;

use Models\User;

class AuthMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $session = $this->container->get('session');

        if ($session->exists('user_id')) {
            try {
                $user = User::find($session->get('user_id'));
                if (!$user) {
                    throw new AuthenticationException(AuthenticationException::INVALID_CREDENTIALS);
                }
                if ($user->remember_token !== $session->get('token')) {
                    throw new AuthenticationException(AuthenticationException::REMEMBER_TOKEN_MISMATCH);
                }
                $this->container['user'] = $user;
            } catch (\Exception $exception) {
                $this->container->get('flash')->addMessage('error', $exception->getMessage());
                return $response->withRedirect($this->container->get('router')->pathFor('login'));
            }
        }

        return $next($request, $response);
    }
}
