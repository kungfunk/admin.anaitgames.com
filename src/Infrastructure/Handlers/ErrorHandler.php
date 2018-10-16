<?php
namespace Infrastructure\Handlers;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Handlers\AbstractError;
use Throwable;

final class ErrorHandler extends AbstractError
{
    private $container;

    private const GENERAL_ERROR_TEMPLATE = 'errors/general.twig';
    private const DATABASE_ERROR_TEMPLATE = 'errors/database.twig';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    public function __invoke(Request $request, Response $response, Throwable $throwable)
    {
        $this->container
            ->get('errorLogger')
            ->critical($throwable->getMessage() . "\n" . $throwable->getTraceAsString());

        $template = ($throwable instanceof \PDOException)
            ? self::DATABASE_ERROR_TEMPLATE
            : self::GENERAL_ERROR_TEMPLATE;

        $response->withStatus(500);

        return $this->container->get('twig')->render(
            $response,
            $template,
            [
                'error' => $throwable->getMessage(),
                'stack' => $throwable->getTraceAsString(),
                'isDebug' => getenv('DEBUG')
            ]
        );
    }
}
