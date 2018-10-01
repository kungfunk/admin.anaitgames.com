<?php
namespace Infrastructure\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Monolog\Logger;
use Infrastructure\Monolog\EloquentHandler;
use Infrastructure\Monolog\RequestProcessor;

class AppLoggerServiceProvider implements ServiceProviderInterface
{
    private const NAME = 'appLogger';

    public function register(Container $container)
    {
        $logger = new Logger(self::NAME);
        $logger->pushHandler(new EloquentHandler($container->session));
        $logger->pushProcessor(new RequestProcessor($container->request));

        $container['appLogger'] = function () use ($logger) {
            return $logger;
        };
    }
}
