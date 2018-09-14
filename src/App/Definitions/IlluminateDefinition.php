<?php
namespace App\Definitions;

use Illuminate\Database\Capsule\Manager as Capsule;

class IlluminateDefinition extends AbstractContainerDefinition
{

    private $config;

    public function __construct(Array $config)
    {
        $this->config = $config;
    }

    public function getSettingsKey()
    {
        return 'settings.db';
    }

    public function __invoke()
    {
        $capsule = new Capsule;
        $capsule->addConnection($this->config[$this->getSettingsKey()]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return [
            Capsule::class => function () use ($capsule) {
                return $capsule;
            }
        ];
    }
}
