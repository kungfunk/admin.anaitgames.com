<?php
date_default_timezone_set('Europe/Madrid');

use Dotenv\Dotenv;
use Slim\App;

require '../vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();

$config = include 'config.php';

$app = new App($config);

include 'handlers.php';
include 'middleware.php';
include 'commands.php';
include 'routes.php';

$app->run();
