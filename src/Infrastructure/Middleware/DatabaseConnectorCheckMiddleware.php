<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DatabaseConnectorCheckMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        try {
            $this->container->db->bootEloquent();
        } catch (\Exception $exception) {
            $this->container->errorLogger->critical($exception->getMessage() . "\n" . $exception->getTraceAsString());
            die('Error al conectar con la base de datos');
        }

        return $next($request, $response);
    }
}
