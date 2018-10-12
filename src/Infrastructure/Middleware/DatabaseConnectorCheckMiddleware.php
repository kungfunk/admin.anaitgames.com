<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class DatabaseConnectorCheckMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        try {
            $this->container->get('db')->bootEloquent();
        } catch (\Exception $exception) {
            $this->container
                ->get('errorLogger')
                ->critical($exception->getMessage() . "\n" . $exception->getTraceAsString());
            die('Error al conectar con la base de datos');
        }

        return $next($request, $response);
    }
}
