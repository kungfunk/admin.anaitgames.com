<?php
use Slim\Flash\Messages;

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

$container['errorHandler'] = function ($container) {
    return new ErrorHandler($container['logger'], $container['view']);
};

$container['flash'] = function () {
    return new Messages();
};
