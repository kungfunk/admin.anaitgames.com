<?php
use Infrastructure\Providers\ErrorLoggerServiceProvider;
use Infrastructure\Providers\QueryLoggerServiceProvider;
use Infrastructure\Providers\EloquentServiceProvider;
use Infrastructure\Providers\TwigServiceProvider;

global $app;

$container = $app->getContainer();

$container->register(new ErrorLoggerServiceProvider);
$container->register(new QueryLoggerServiceProvider);
$container->register(new EloquentServiceProvider);
$container->register(new TwigServiceProvider);
