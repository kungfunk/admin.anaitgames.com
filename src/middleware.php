<?php
use Slim\Middleware\Session;

use Infrastructure\Middleware\PreviousInputMiddleware;
use Infrastructure\Middleware\CsrfViewMiddleware;

$app->add(new PreviousInputMiddleware($container));
$app->add(new CsrfViewMiddleware($container));
$app->add($container->csrf);
$app->add(new Session($config['settings']['session']));
