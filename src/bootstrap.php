<?php
error_reporting(E_ALL);
date_default_timezone_set('Europe/Madrid');

use Dotenv\Dotenv;
use Slim\App;

require '../vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();

$config = include 'config.php';

$app = new App($config);

// container DI
include 'handlers.php';
include 'middleware.php';
include 'services.php';
include 'repositories.php';

// Routes files
include 'routes.php';

$app->run();
