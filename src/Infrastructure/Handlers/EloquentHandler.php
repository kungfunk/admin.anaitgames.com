<?php
namespace Infrastructure\Handlers;

use Interop\Container\ContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentHandler
{
    public static function handle(ContainerInterface $container)
    {
        $settings = $container->settings['db'];
        $capsule = new Capsule;
        $capsule->addConnection($settings);
        $capsule->setAsGlobal();
        $capsule::listen(function($sql) {
            var_dump($sql);
        });

        return $capsule;
    }
}
