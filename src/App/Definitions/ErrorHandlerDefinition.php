<?php
namespace App\Definitions;

use App\Handlers\ErrorHandler;
use Monolog\Logger;
use Slim\Views\Twig;

class ErrorHandlerDefinition
{
    public function __invoke()
    {
        return [
            'errorHandler' => function ($container) {
                return new ErrorHandler(
                    $container->get(Logger::class),
                    $container->get(Twig::class)
                );
            }
        ];
    }
}
