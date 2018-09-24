<?php
namespace Infrastructure\Handlers;

use Interop\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class LoggerHandler
{
    public static function handle(ContainerInterface $container)
    {
        $settings = $container['settings']['logger'];

        $logger = new Logger($settings['name']);
        $formatter = new LineFormatter(
            "[%datetime%] [%level_name%]: %message% %context%\n",
            null,
            true,
            true
        );

        $rotating = new RotatingFileHandler($settings['path'], 0, Logger::DEBUG);
        $rotating->setFormatter($formatter);
        $logger->pushHandler($rotating);
        return $logger;
    }
}
