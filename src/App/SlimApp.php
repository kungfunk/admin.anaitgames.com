<?php
namespace App;

use DI\Bridge\Slim\App;
use DI\ContainerBuilder;
use App\Definitions\IlluminateDefinition;
use App\Definitions\LoggerDefinition;
use App\Definitions\TwigDefinition;

class SlimApp extends App
{
    private $config;

    public function __construct(Array $config)
    {
        $this->config = $config;
        parent::__construct();
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->addDefinitions($this->config);

        foreach ($this->getContainerDefinitions() as $definition) {
            $builder->addDefinitions($definition());
        }
    }

    protected function getContainerDefinitions()
    {
        return [
            new IlluminateDefinition,
            new LoggerDefinition,
            new TwigDefinition,
        ];
    }
}
