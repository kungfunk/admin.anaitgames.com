<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Domain\User\IpBan;

class IpBanMiddleware extends Middleware
{
    private const TEMPLATE = 'routes/ban.twig';

    public function __invoke(Request $request, Response $response, $next)
    {
        $ip = $request->getServerParam('REMOTE_ADDR');
        $ban = IpBan::whereIp($ip)->active()->first();

        if ($ban) {
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
