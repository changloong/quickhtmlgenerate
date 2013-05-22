<?php

require __DIR__ . '/../vendor/autoload.php' ;

if( 'dev' === getenv('APP_ENV') ) {
	ini_set('display_errors', 1);
	$app = new App\Application();
	require __DIR__.'/config/dev.php';
} else {
	ini_set('display_errors', 0);
	$app = new App\Application();
	require __DIR__.'/config/prod.php';
}

App\Application::config($app);

$data = $app['filter']( $_SERVER['SCRIPT_FILENAME'], false ) ;

if( $data  ) {
	echo $data ;
        exit ;
} else {
	return false ;
}
