<?php
namespace App\Definitions;

use Interop\Container\ContainerInterface;
use Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler as StreamHandler;

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
                $file_handler = new StreamHandler($settings['path']);
                $logger->pushHandler($file_handler);

                return $logger;
            }
        ];
    }
}
