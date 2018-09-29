<?php
use Slim\Flash\Messages;
use Slim\Csrf\Guard as CsrfGuard;
use SlimSession\Helper as SessionHelper;

use Infrastructure\Handlers\ErrorHandler;
use Infrastructure\Handlers\ErrorLoggerHandler;
use Infrastructure\Handlers\QueryLoggerHandler;
use Infrastructure\Handlers\TwigHandler;
use Infrastructure\Handlers\EloquentHandler;

global $app;

$container = $app->getContainer();

$container['errorLogger'] = function ($container) {
    return ErrorLoggerHandler::handle($container);
};

$container['queryLogger'] = function ($container) {
    return QueryLoggerHandler::handle($container);
};

$container['session'] = function () {
    return new SessionHelper;
};

$container['errorHandler'] = function ($container) {
    return new ErrorHandler($container);
};

$container['flash'] = function () {
    return new Messages;
};

$container['view'] = function ($container) {
    return TwigHandler::handle($container);
};

$container['twig'] = $container['view']; // to show twig errors

$container['db'] = function ($container) {
    return EloquentHandler::handle($container);
};

$container['csrf'] = function () {
    return new CsrfGuard;
};
