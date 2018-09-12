<?php
use Dotenv\Dotenv as Dotenv;
use App\SlimApp as App;

require '../vendor/autoload.php';

const BASE_PATH = __DIR__ . '/..';

$dotenv = new Dotenv(BASE_PATH);
$dotenv->load();

$config = include "config.php";

$app = new App($config);

include "routes.php";

$app->run();
