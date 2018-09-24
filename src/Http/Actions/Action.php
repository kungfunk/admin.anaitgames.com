<?php
namespace Http\Actions;

use Slim\Container;

abstract class Action
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->has($property)) {
            return $this->container->{$property};
        }
    }
}
