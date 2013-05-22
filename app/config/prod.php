<?php

$app['debug']       = false ;
$app['root_dir']    = __DIR__ . '/../../' ;


$app['twig.templates']  = array() ;

$app['twig.path']  = array(
        __DIR__ . '/../../web_twig' ,
        __DIR__ . '/../../web' ,
    );

$app['twig.options.cache']  = __DIR__ . '/../cache/twig' ;