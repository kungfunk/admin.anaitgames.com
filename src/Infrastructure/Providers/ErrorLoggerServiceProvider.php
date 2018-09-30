<?php
namespace Infrastructure\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class ErrorLoggerServiceProvider implements ServiceProviderInterface
{
    private const NAME = 'logger';
    private const FILENAME = 'app.log';
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

        $container['errorLogger'] = function () use ($logger) {
            return $logger;
        };
    }
}
