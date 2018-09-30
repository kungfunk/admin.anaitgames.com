<?php
namespace Infrastructure\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class QueryLoggerServiceProvider implements ServiceProviderInterface
{
    private const NAME = 'queryLogger';
    private const FILENAME = 'sql.log';
    private const FORMAT_STRING = "[%datetime%] [%level_name%]: %message% %context%\n";

    public function register(Container $container)
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

        $container['queryLogger'] = function () use ($logger) {
            return $logger;
        };
    }
}
