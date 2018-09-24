<?php
session_start();
date_default_timezone_set('Europe/Madrid');

use Dotenv\Dotenv;
use Slim\App;
use Infrastructure\Database\EloquentConnector;

require '../vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();

$config = include 'config.php';

$app = new App($config);

include 'handlers.php';
include 'routes.php';

EloquentConnector::connect();

$app->run();
