<?php
namespace Infrastructure\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentConnector
{
    private static $capsule;

    public static function connect()
    {
        if (!self::$capsule) {
            $capsule = new Capsule;
            $capsule->addConnection(self::getSettings());
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            $capsule::listen(function($sql) {
                var_dump($sql);
            });

            self::$capsule = $capsule;
        }

        return self::$capsule;
    }

    private static function getSettings()
    {
        $settings = [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION')
        ];

        return $settings;
    }
}
