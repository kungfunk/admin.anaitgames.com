<?php
use Dotenv\Dotenv as Dotenv;
use App\SlimApp as App;

require '../vendor/autoload.php';

$dotenv = new Dotenv(__DIR__ . '/..');
$dotenv->load();

$config = include 'config.php';

$app = new App($config);

include 'routes.php';

$app->run();
