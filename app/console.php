<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Doctrine\DBAL\DriverManager;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$console = new Application('Quick Html Generate', '0.1') ;
$app->boot();

$console
    ->register('server:run')
    ->setDescription('Php build web server')
    ->addOption('dev', null , InputOption::VALUE_NONE, 'The dev mode' )
    ->addOption('address', null , InputOption::VALUE_OPTIONAL, 'The address to use for listen', 'localhost:3000')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {

        $docroot = __DIR__ . '/../web/' ;
        
        $router  = __DIR__ . '/router.php' ;

        $command = escapeshellcmd(
            sprintf(
                '/usr/bin/env php -S %s -t %s %s',
                $input->getOption('address'),
                $docroot ,
                $router
            )
        );

        $output->writeln( $command ) ;

        $app_env    = 'prod' ;
        if( $input->getOption('dev') ) {
            $app_env = 'dev' ;
        }

        $env    = array(
            'PATH'  => getenv('PATH') ,
            'HOME'  => getenv('HOME') ,
            'APP_ENV'  => $app_env ,
        ) ;

        proc_open(
            $command,
            array(
                0 => STDIN,
                1 => STDOUT,
                2 => STDERR
            ),
            $pipes ,
            $docroot ,
            $env
        );
    })
;



$console
    ->register('app:generate:html')
    ->setDescription('generage html pages')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $web_dir    = $app['root_dir'] . 'web' ;
        $obj_dir    = $app['root_dir'] . 'public_html' ;
        
        $gen    = null ;
        
        $gen    = function($from, $to) use($app, & $gen ){
            if( !file_exists($to) ) {
                mkdir($to, 0755 ) ;
            }
            $list  = array() ;
            for( $h = dir($from); $f = $h->read(); ) {
                if( $f =='.' || $f == '..' ) {
                    continue ;
                }
                $_path = $from . '/' . $f ;
                $_to_path  = $to . '/' . $f  ;
                
                if( is_dir($_path) ) {
                    $gen( $_path, $_to_path);
                } else {
                    echo $_path , '->', $_to_path , "\n" ;
                    $data   = $app['filter']( $_path ) ;
                    file_put_contents($_to_path, $data) ;
                }
            }
            $h->close() ;
            
        } ;
        
        $gen($web_dir, $obj_dir) ;
    })
;

return $console;