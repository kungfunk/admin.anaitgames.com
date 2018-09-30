<?php
namespace Infrastructure\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container as EventContainer;

class EloquentServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $settings = $container->settings['db'];
        $capsule = new Capsule;
        $capsule->addConnection($settings);
        $capsule->setEventDispatcher(new Dispatcher(new EventContainer));
        $capsule->setAsGlobal();
        $capsule::listen(function ($data) use ($container) {
            $container->queryLogger->debug("({$data->time} ms) {$data->sql}", $data->bindings);
        });

        $capsule->bootEloquent();

        $container['db'] = function ($c) use ($capsule) {
            return $capsule;
        };
        return $capsule;
    }
}
