<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BanMiddleware extends Middleware
{
    private const TEMPLATE = 'routes/ban.twig';

    public function __invoke(Request $request, Response $response, $next)
    {
        $user = $this->container->loggedUser->get();
        if ($user->isBanned()) {
            $this->container->session->clear();
            $ban = $user->getActiveBan();
            return $this->container->twig->render(
                $response,
                static::TEMPLATE,
                [
                    'ip' => $ban->ip,
                    'message' => $ban->reason,
                    'expires' => $ban->expires
                ]
            );
        }

        return $next($request, $response);
    }
}
