<?php

namespace App;


class Application extends \Silica\Application {
    
    
    /**
     * @return \Smarty
     */
    public function smarty(){
        return $this['smarty'];
    }

    static public function config(Application $app ){
        
        $app->protect('filter', function( $filename ) use($app) {
            $ext = pathinfo( $filename , PATHINFO_EXTENSION ) ;
            $basename = substr(pathinfo( $filename , PATHINFO_BASENAME ) , 0 , 0 - 1 - strlen($ext) ) ;
            
            if( in_array($ext,  array('html', 'htm')) ) {
                
                $app['smarty']->assign( 'pagename', $basename ) ;
                
                $app['smarty']->assign( 'subpagename', $basename ) ;
                
                return $app['smarty']->fetch($filename) ;
            } else {
                return file_get_contents($filename) ;
            }
        });
        
        $app->share('smarty', function($app) {
            
            $cache_dir  = $app['root_dir'] . '/app/cache/' ; 
            
            $smarty = new \Smarty();
            
            $smarty->left_delimiter = '{%' ;
            $smarty->right_delimiter = '%}' ;
            $smarty->debugging  = $app['debug'] ;
            
            $smarty->template_dir   = $app['root_dir'] . 'web' ;
            // $smarty->config_dir     = '' ;
            $smarty->compile_dir   = $app['root_dir'] . 'app/cache/compile_dir' ;
            $smarty->cache_dir   = $app['root_dir'] . 'app/cache/cache_dir' ;
            
            return $smarty ;
        });
    }
    
    public function boot(){
        
    }
}
