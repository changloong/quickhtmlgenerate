<?php

namespace App;


class Application extends \Silica\Application {
    
    static public function config(Application $app ){
        
        $app->share('filesystem',  function($app){
           return new \Symfony\Component\Filesystem\Filesystem() ; 
        });
        
        $app->protect('filter', function( $filename , $fetch_data = true ) use($app) {
            
            if( file_exists($filename) ) {
                
                $ext = pathinfo( $filename , PATHINFO_EXTENSION ) ;
                
                $basename = substr(pathinfo( $filename , PATHINFO_BASENAME ) , 0 , 0 - 1 - strlen($ext) ) ;

                if( in_array($ext,  array('html', 'htm')) ) {
                    
                    $_path  = rtrim( $app['filesystem']->makePathRelative( realpath($filename) , realpath( $app['root_dir'] . 'web' ) )  , '/') ;
                    
                    return $app['twig']->render( $_path , array(
                        'pagename'  => $basename ,
                        'subpagename'  => $basename ,
                    )) ;
                    
                } else if( $fetch_data ) {
                    return file_get_contents($filename) ;
                }
            }
            
            return false ;
        });
        
        $app->share('twig', function($app) {
            
            $twig_options = array(
                    'charset'          => $app['charset'],
                    'debug'            => $app['debug'],
                    'strict_variables' => $app['debug'] ,
                    'cache'            => isset($app['twig.options.cache']) ? $app['twig.options.cache'] : false,
                ) ;
            
            if( isset($app['twig.options']) ) {
                $twig_options = array_replace( $twig_options , $app['twig.options'] ) ;
            }

            $twig = new \Twig_Environment( new \Twig_Loader_Chain( array(
                    new \Twig_Loader_Array($app['twig.templates']) ,
                    new \Twig_Loader_Filesystem( $app['twig.path']) ,
                )) , $twig_options ) ;
           
            $twig->addGlobal('app', $app);
            
            $twig->addExtension( new \App\Twig\Extension\TwigCoreExtension() );
            
            if ($app['debug']) {
                $twig->addExtension(new \Twig_Extension_Debug());
            }
            
            return $twig ;
        });
    }
    
    public function boot(){
        
    }
}
