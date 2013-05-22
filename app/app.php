<?php

ini_set('display_errors', 0);
require_once __DIR__.'/../vendor/autoload.php';
$app = new App\Application();
require __DIR__.'/config/prod.php';
App\Application::config($app);

require __DIR__.'/../src/controllers.php';

$app->run();
