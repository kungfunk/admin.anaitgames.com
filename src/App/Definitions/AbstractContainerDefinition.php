<?php
namespace App\Definitions;

use Psr\Container\ContainerInterface;

abstract class AbstractContainerDefinition
{
    protected function getSettings(ContainerInterface $container)
    {
        return $container->get($this->getSettingsKey());
    }
}
