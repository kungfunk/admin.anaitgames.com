<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig\TwigFunction;

class TwigGlobalsMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $environment = $this->container->twig->getEnvironment();
        $environment->addGlobal('queryStringParams', $this->container->request->getQueryParams());
        $environment->addGlobal('flash', $this->container->flash);
        $environment->addFunction(
            new TwigFunction('dump', function ($data) {
                return '<pre>' . print_r($data) . '</pre>';
            })
        );

        return $next($request, $response);
    }
}
