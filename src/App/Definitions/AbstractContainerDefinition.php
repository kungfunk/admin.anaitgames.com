<?php
namespace App\Definitions;

use Interop\Container\ContainerInterface;

abstract class AbstractContainerDefinition
{
    protected function getSettings(ContainerInterface $container)
    {
        return $container->get($this->getSettingsKey());
    }
}
