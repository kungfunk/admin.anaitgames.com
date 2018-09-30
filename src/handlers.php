<?php
use Slim\Flash\Messages;
use Slim\Csrf\Guard as CsrfGuard;
use SlimSession\Helper as SessionHelper;
use Infrastructure\Handlers\ErrorHandler;

global $app;

$container = $app->getContainer();

$container['session'] = function () {
    return new SessionHelper;
};

$container['errorHandler'] = function ($container) {
    return new ErrorHandler($container);
};

$container['flash'] = function () {
    return new Messages;
};

$container['csrf'] = function () {
    return new CsrfGuard;
};
