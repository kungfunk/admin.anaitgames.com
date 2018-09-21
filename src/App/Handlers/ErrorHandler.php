<?php
namespace App\Handlers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\AbstractError;
use Monolog\Logger;
use Slim\Views\Twig;
use Throwable;

final class ErrorHandler extends AbstractError
{
    protected $logger;
    protected $twig;

    private const ERROR_TEMPLATE = 'routes/error.twig';
    private const DEFAULT_ERROR_TEXT = 'Error general';
    private const DATABASE_ERROR_TEXT = 'Error al conectar con la base de datos';

    public function __construct(Logger $logger, Twig $twig)
    {
        $this->logger = $logger;
        $this->twig = $twig;
        parent::__construct();
    }

    public function __invoke(Request $request, Response $response, Throwable $throwable)
    {
        $this->logger->critical($throwable->getMessage() . "\n" . $throwable->getTraceAsString());
        $message = self::DEFAULT_ERROR_TEXT;

        if ($throwable instanceof \PDOException) {
            $message = self::DATABASE_ERROR_TEXT;
        }

        $response->withStatus(500);

        return $this->twig->render(
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
