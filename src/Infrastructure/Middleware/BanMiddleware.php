<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class BanMiddleware extends Middleware
{
    private const TEMPLATE = 'errors/ban.twig';

    public function __invoke(Request $request, Response $response, $next)
    {
        if ($this->container->has('user')) {
            $user = $this->container->get('user');
            $session = $this->container->get('session');

            if ($user->isBanned()) {
                $session->clear();
                $ban = $user->getActiveBan();

                $response->withStatus(403);

                return $this->container->get('twig')->render(
                    $response,
                    static::TEMPLATE,
                    [
                        'ip' => $ban->ip,
                        'message' => $ban->reason,
                        'expires' => $ban->expires
                    ]
                );
            }
        }

        return $next($request, $response);
    }
}
