<?php

$app->match('/%*', function($p) use($app) {
    echo $app['filter']( $_SERVER['SCRIPT_FILENAME'] ) ;
});