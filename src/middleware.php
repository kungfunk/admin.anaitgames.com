<?php
use Slim\Middleware\Session;

use Infrastructure\Middleware\PreviousInputMiddleware;
use Infrastructure\Middleware\CsrfViewMiddleware;
use Infrastructure\Middleware\DatabaseConnectorCheckMiddleware;
use Infrastructure\Middleware\TwigGlobalsMiddleware;
use Infrastructure\Middleware\IpBanMiddleware;

global $app;

$container = $app->getContainer();

$app->add(new PreviousInputMiddleware($container));
$app->add(new CsrfViewMiddleware($container));
$app->add($container->get('csrf'));
$app->add(new DatabaseConnectorCheckMiddleware($container));
$app->add(new TwigGlobalsMiddleware($container));
$app->add(new Session($container->get('settings')['session']));
$app->add(new IpBanMiddleware($container));
