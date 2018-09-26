<?php
namespace Infrastructure\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CsrfViewMiddleware extends Middleware
{
    private const INDEX_NAME = 'csrf';

    protected $tokenName;
    protected $tokenNameKey;
    protected $tokenValue;
    protected $tokenValueKey;

    public function __invoke(Request $request, Response $response, $next)
    {
        $this->tokenName = $this->container->csrf->getTokenName();
        $this->tokenNameKey = $this->container->csrf->getTokenNameKey();
        $this->tokenValue = $this->container->csrf->getTokenValue();
        $this->tokenValueKey = $this->container->csrf->getTokenValueKey();

        $this->container->view->getEnvironment()->addGlobal(self::INDEX_NAME, $this->generateInputFields());

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
