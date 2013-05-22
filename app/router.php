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

$filename   = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'] ;

$data = $app['filter']( $filename , false ) ;

if( $data  ) {
	echo $data ;
        exit ;
} else {
	return false ;
}
