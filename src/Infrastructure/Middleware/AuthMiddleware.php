<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Infrastructure\Exceptions\NotAuthorizedException;
use Infrastructure\Exceptions\BannedUserException;
use Infrastructure\Exceptions\NotEnoughPermissionsException;

class AuthMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        try {
            if (!$this->container->loggedUser->isAuth()) {
                throw new NotAuthorizedException(NotAuthorizedException::USER_IS_NOT_LOGGED_IN);
            }
            $user = $this->container->loggedUser->get();
            if ($user->isBanned()) {
                throw new BannedUserException(BannedUserException::USER_IS_BANNED);
            }
            if (!$user->isAdmin()) {
                throw new NotAuthorizedException(NotEnoughPermissionsException::NOT_ENOUGH_PERMISSIONS);
            }
        } catch (\Exception $exception) {
            $this->container->session->clear();
            $this->container->flash->addMessage('error', $exception->getMessage());
            return $response->withRedirect($this->container->router->pathFor('login'));
        }

        return $next($request, $response);
    }
}
