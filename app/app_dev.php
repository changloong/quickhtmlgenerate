<?php

ini_set('display_errors', 1);
require __DIR__.'/../vendor/autoload.php';
$app = new App\Application();
require __DIR__.'/config/dev.php';
App\Application::config($app);

require __DIR__.'/../src/controllers.php';

$app->run();
