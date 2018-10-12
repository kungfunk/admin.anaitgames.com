<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

use Models\IpBan;

class IpBanMiddleware extends Middleware
{
    private const TEMPLATE = 'routes/ban.twig';

    public function __invoke(Request $request, Response $response, $next)
    {
        $ip = $request->getServerParam('REMOTE_ADDR');
        $ban = IpBan::whereIp($ip)->active()->first();

        if ($ban) {
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

        return $next($request, $response);
    }
}
