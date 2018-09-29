<?php
namespace Infrastructure\Handlers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\AbstractError;
use Throwable;

final class ErrorHandler extends AbstractError
{
    private $container;

    private const ERROR_TEMPLATE = 'routes/error.twig';
    private const DEFAULT_ERROR_TEXT = 'Error general';
    private const DATABASE_ERROR_TEXT = 'Error al conectar con la base de datos';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    public function __invoke(Request $request, Response $response, Throwable $throwable)
    {
        $this->container->errorLogger->critical($throwable->getMessage() . "\n" . $throwable->getTraceAsString());
        $message = self::DEFAULT_ERROR_TEXT;

        if ($throwable instanceof \PDOException) {
            $message = self::DATABASE_ERROR_TEXT;
        }

        $response->withStatus(500);

        return $this->container->twig->render(
            $response,
            self::ERROR_TEMPLATE,
            [
                'message' => $message,
                'error' => $throwable->getMessage(),
                'stack' => $throwable->getTraceAsString(),
                'isDebug' => getenv('DEBUG')
            ]
        );
    }
}
