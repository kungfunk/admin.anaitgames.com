<?php
namespace Infrastructure\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class CsrfViewMiddleware extends Middleware
{
    private const INDEX_NAME = 'csrf';

    protected $tokenName;
    protected $tokenNameKey;
    protected $tokenValue;
    protected $tokenValueKey;

    public function __invoke(Request $request, Response $response, $next)
    {
        $this->tokenName = $this->container->get('csrf')->getTokenName();
        $this->tokenNameKey = $this->container->get('csrf')->getTokenNameKey();
        $this->tokenValue = $this->container->get('csrf')->getTokenValue();
        $this->tokenValueKey = $this->container->get('csrf')->getTokenValueKey();

        $this->container->get('view')->getEnvironment()->addGlobal(self::INDEX_NAME, $this->generateInputFields());

        return $next($request, $response);
    }

    public function generateInputFields()
    {
        return '
            <input type="hidden" name="' . $this->tokenNameKey . '" value="' . $this->tokenName . '">
            <input type="hidden" name="' . $this->tokenValueKey . '" value="' . $this->tokenValue . '">
        ';
    }
}
