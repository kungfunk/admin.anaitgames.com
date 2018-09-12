<?php
namespace App\Definitions;

use Psr\Container\ContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class IlluminateDefinition extends AbstractContainerDefinition
{
    public function getSettingsKey()
    {
        return 'settings.db';
    }

    public function __invoke()
    {
        return [
            Capsule::class => function (ContainerInterface $container) {
                $settings = $this->getSettings($container);
                $capsule = new Capsule;
                $capsule->addConnection($settings);
                $capsule->setAsGlobal();
                $capsule->bootEloquent();

                return $capsule;
            }
        ];
    }
}
