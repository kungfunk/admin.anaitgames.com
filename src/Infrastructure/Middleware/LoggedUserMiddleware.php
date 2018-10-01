<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Domain\User\UsersRepository;
use Infrastructure\Exceptions\UserNotFoundException;

class LoggedUserMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        if ($this->container->session->exists('user_id')) {
            $usersRepository = new UsersRepository;
            $user = $usersRepository->getUserById($this->container->session->get('user_id'));
            if (!$user) {
                throw new UserNotFoundException(UserNotFoundException::USER_NOT_FOUND);
            }
            $this->container->loggedUser->set($user);
        }

        return $next($request, $response);
    }
}
