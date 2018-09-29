<?php
namespace Infrastructure\Handlers;

use Interop\Container\ContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

class EloquentHandler
{
    public static function handle(ContainerInterface $container)
    {
        $settings = $container->settings['db'];
        $capsule = new Capsule;
        $capsule->addConnection($settings);
        $capsule->setEventDispatcher(new Dispatcher(new Container));
        $capsule->setAsGlobal();
        $capsule::listen(function ($data) use ($container) {
            $container->queryLogger->debug("({$data->time} ms) {$data->sql}", $data->bindings);
        });

        return $capsule;
    }
}
