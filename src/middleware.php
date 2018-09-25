<?php

use Infrastructure\Middleware\PreviousInputMiddleware;

$app->add(new PreviousInputMiddleware($container));
