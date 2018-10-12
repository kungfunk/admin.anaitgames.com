<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;
use Twig\TwigFunction;

class TwigGlobalsMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $environment = $this->container->get('twig')->getEnvironment();
        $environment->addGlobal('queryStringParams', $this->container->get('request')->getQueryParams());
        $environment->addGlobal('flash', $this->container->get('flash'));
        $environment->addFunction(
            new TwigFunction('dump', function ($data) {
                return '<pre>' . print_r($data) . '</pre>';
            })
        );

        return $next($request, $response);
    }
}
