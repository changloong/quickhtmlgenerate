<?php

$return = false ;

if ( file_exists($_SERVER['SCRIPT_FILENAME']) ) {
    
    $ext = pathinfo( $_SERVER['SCRIPT_FILENAME'], PATHINFO_EXTENSION ) ;
    
    $catch_ext_list = array( 'html', 'htm' ) ;
    
    if(in_array($ext, $catch_ext_list) ) {
        $return = true ;
    }
}

if( $return ) {
    if( 'dev' === getenv('APP_ENV') ) {
        require   __DIR__ . '/app_dev.php' ;
    } else {
        require   __DIR__ . '/app.php' ;
    }
    exit ;
}

return false; 