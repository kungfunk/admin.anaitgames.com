<?php
namespace Infrastructure\Handlers;

use Interop\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class QueryLoggerHandler
{
    private const NAME = 'queryLogger';
    private const FILENAME = 'sql.log';
    private const FORMAT_STRING = "[%datetime%] [%level_name%]: %message% %context%\n";

    public static function handle(ContainerInterface $container)
    {
        $path = $container['settings']['logger']['path'] . self::FILENAME;

        $logger = new Logger(self::NAME);
        $formatter = new LineFormatter(
            self::FORMAT_STRING,
            null,
            true,
            true
        );

        $rotating = new RotatingFileHandler($path, 0, Logger::DEBUG);
        $rotating->setFormatter($formatter);
        $logger->pushHandler($rotating);
        return $logger;
    }
}
