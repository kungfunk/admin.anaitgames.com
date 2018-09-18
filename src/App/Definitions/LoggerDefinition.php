<?php
namespace App\Definitions;

use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class LoggerDefinition extends AbstractContainerDefinition
{
    public function getSettingsKey()
    {
        return 'settings.logger';
    }

    public function __invoke()
    {
        return [
            Logger::class => function (ContainerInterface $container) {
                $settings = $this->getSettings($container);
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
        ];
    }
}
