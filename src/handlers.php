<?php
use Slim\Flash\Messages;
use Slim\Csrf\Guard as CsrfGuard;

use Infrastructure\Handlers\ErrorHandler;
use Infrastructure\Handlers\LoggerHandler;
use Infrastructure\Handlers\TwigHandler;

$container = $app->getContainer();

$container['logger'] = function ($container) {
    return LoggerHandler::handle($container);
};

$container['view'] = function ($container) {
    return TwigHandler::handle($container);
};

$container['twig'] = $container['view']; // to show twig errors

$container['errorHandler'] = function ($container) {
    return new ErrorHandler($container);
};

$container['flash'] = function () {
    return new Messages;
};

$container['csrf'] = function () {
    return new CsrfGuard;
};
