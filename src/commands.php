<?php
use Domain\User\Commands\CheckUsernameAndPassword;

$container = $app->getContainer();

$container['checkUsernameAndPasswordCommand'] = function () {
    return new CheckUsernameAndPassword;
};
